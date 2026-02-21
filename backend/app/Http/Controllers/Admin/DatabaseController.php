<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Inertia\Inertia;

class DatabaseController extends Controller
{
    /**
     * Show the database management page.
     */
    public function index()
    {
        return Inertia::render('Admin/Database', [
            'tables' => $this->getTablesOverview(),
            'dbInfo' => $this->getDatabaseInfo(),
            'backups' => $this->getBackupsList(),
        ]);
    }

    /**
     * Get an overview of all tables with row counts and sizes.
     */
    private function getTablesOverview(): array
    {
        $dbName = config('database.connections.mysql.database');

        $tables = DB::select("
            SELECT
                TABLE_NAME as `name`,
                TABLE_ROWS as `rows`,
                ROUND((DATA_LENGTH + INDEX_LENGTH) / 1024, 1) as `size_kb`,
                ENGINE as `engine`,
                TABLE_COLLATION as `collation`,
                UPDATE_TIME as `last_updated`
            FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = ?
            ORDER BY TABLE_NAME
        ", [$dbName]);

        return array_map(fn($t) => (array) $t, $tables);
    }

    /**
     * Get general database information.
     */
    private function getDatabaseInfo(): array
    {
        $dbName = config('database.connections.mysql.database');

        $sizeResult = DB::select("
            SELECT ROUND(SUM(DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024, 2) as size_mb
            FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = ?
        ", [$dbName]);

        $version = DB::select("SELECT VERSION() as version")[0]->version ?? 'Unknown';
        $tableCount = DB::select("SELECT COUNT(*) as cnt FROM information_schema.TABLES WHERE TABLE_SCHEMA = ?", [$dbName])[0]->cnt;

        return [
            'name' => $dbName,
            'version' => $version,
            'size_mb' => $sizeResult[0]->size_mb ?? '0.00',
            'table_count' => $tableCount,
            'connection' => config('database.default'),
            'host' => config('database.connections.mysql.host'),
            'port' => config('database.connections.mysql.port'),
            'charset' => config('database.connections.mysql.charset'),
        ];
    }

    /**
     * Get list of existing backup files.
     */
    private function getBackupsList(): array
    {
        $backupDir = storage_path('app/backups');

        if (!is_dir($backupDir)) {
            return [];
        }

        $files = glob($backupDir . '/*.sql');
        $backups = [];

        foreach ($files as $file) {
            $backups[] = [
                'filename' => basename($file),
                'size_kb' => round(filesize($file) / 1024, 1),
                'created_at' => date('Y-m-d H:i:s', filemtime($file)),
            ];
        }

        // Sort newest first
        usort($backups, fn($a, $b) => strcmp($b['created_at'], $a['created_at']));

        return $backups;
    }

    /**
     * Create a full database backup (SQL dump).
     */
    public function createBackup()
    {
        $backupDir = storage_path('app/backups');
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $dbName = config('database.connections.mysql.database');
        $filename = "backup-{$dbName}-" . date('Y-m-d-His') . '.sql';
        $filepath = $backupDir . DIRECTORY_SEPARATOR . $filename;

        try {
            $tables = DB::select("SELECT TABLE_NAME as `name` FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? ORDER BY TABLE_NAME", [$dbName]);
            $tables = array_map(fn($t) => $t->name, $tables);
            $sql = "-- Database Backup: {$dbName}\n";
            $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
            $sql .= "-- Server: " . config('database.connections.mysql.host') . "\n";
            $sql .= "-- PHP Version: " . PHP_VERSION . "\n";
            $sql .= "-- --------------------------------------------------------\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
            $sql .= "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n\n";

            foreach ($tables as $table) {
                // Table structure
                $createTable = DB::select("SHOW CREATE TABLE `{$table}`");
                $sql .= "-- --------------------------------------------------------\n";
                $sql .= "-- Table structure for `{$table}`\n";
                $sql .= "-- --------------------------------------------------------\n\n";
                $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";

                $createKey = 'Create Table';
                $sql .= $createTable[0]->$createKey . ";\n\n";

                // Table data
                $rows = DB::table($table)->get();
                if ($rows->count() > 0) {
                    $sql .= "-- Dumping data for `{$table}`\n\n";

                    foreach ($rows as $row) {
                        $values = collect((array) $row)->map(function ($value) {
                            if (is_null($value)) return 'NULL';
                            return "'" . addslashes((string) $value) . "'";
                        })->implode(', ');

                        $sql .= "INSERT INTO `{$table}` VALUES ({$values});\n";
                    }
                    $sql .= "\n";
                }
            }

            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

            file_put_contents($filepath, $sql);

            return response()->json([
                'success' => true,
                'message' => 'Backup created successfully.',
                'backup' => [
                    'filename' => $filename,
                    'size_kb' => round(filesize($filepath) / 1024, 1),
                    'created_at' => date('Y-m-d H:i:s'),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Backup failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Download a backup file.
     */
    public function downloadBackup(string $filename)
    {
        // Prevent directory traversal
        $filename = basename($filename);
        $filepath = storage_path('app/backups/' . $filename);

        if (!file_exists($filepath)) {
            abort(404, 'Backup file not found.');
        }

        return response()->download($filepath, $filename, [
            'Content-Type' => 'application/sql',
        ]);
    }

    /**
     * Delete a backup file.
     */
    public function deleteBackup(string $filename)
    {
        $filename = basename($filename);
        $filepath = storage_path('app/backups/' . $filename);

        if (!file_exists($filepath)) {
            return response()->json(['success' => false, 'message' => 'File not found.'], 404);
        }

        unlink($filepath);

        return response()->json(['success' => true, 'message' => 'Backup deleted.']);
    }

    /**
     * Restore the database from a backup file.
     */
    public function restoreBackup(Request $request)
    {
        $request->validate([
            'filename' => 'required|string',
        ]);

        $filename = basename($request->filename);
        $filepath = storage_path('app/backups/' . $filename);

        if (!file_exists($filepath)) {
            return response()->json(['success' => false, 'message' => 'Backup file not found.'], 404);
        }

        try {
            $sql = file_get_contents($filepath);

            DB::unprepared($sql);

            // Clear all caches after restore
            Artisan::call('optimize:clear');

            return response()->json([
                'success' => true,
                'message' => 'Database restored successfully from ' . $filename,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Restore failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Run pending migrations.
     */
    public function runMigrations()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();

            return response()->json([
                'success' => true,
                'message' => 'Migrations completed.',
                'output' => $output,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Migration failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Run all seeders.
     */
    public function runSeeders()
    {
        try {
            Artisan::call('db:seed', ['--force' => true]);
            $output = Artisan::output();

            return response()->json([
                'success' => true,
                'message' => 'Seeders completed.',
                'output' => $output,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Seeding failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Clear all application caches.
     */
    public function clearCache()
    {
        try {
            Artisan::call('optimize:clear');
            $output = Artisan::output();

            return response()->json([
                'success' => true,
                'message' => 'All caches cleared.',
                'output' => $output,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cache clear failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get table details — columns and sample data.
     */
    public function tableDetails(string $table)
    {
        // Only allow existing tables
        if (!Schema::hasTable($table)) {
            return response()->json(['success' => false, 'message' => 'Table not found.'], 404);
        }

        $columns = Schema::getColumns($table);
        $rowCount = DB::table($table)->count();
        $sampleRows = DB::table($table)->limit(10)->get();

        return response()->json([
            'success' => true,
            'table' => $table,
            'columns' => $columns,
            'row_count' => $rowCount,
            'sample_rows' => $sampleRows,
        ]);
    }

    /**
     * Truncate a specific table. Dangerous — for admin use only.
     */
    public function truncateTable(Request $request)
    {
        $request->validate([
            'table' => 'required|string',
        ]);

        $table = $request->table;

        // Protect critical tables from truncation
        $protected = ['users', 'migrations', 'personal_access_tokens'];
        if (in_array($table, $protected)) {
            return response()->json([
                'success' => false,
                'message' => "Table `{$table}` is protected and cannot be truncated.",
            ], 403);
        }

        if (!Schema::hasTable($table)) {
            return response()->json(['success' => false, 'message' => 'Table not found.'], 404);
        }

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::table($table)->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            return response()->json([
                'success' => true,
                'message' => "Table `{$table}` has been truncated.",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Truncate failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
