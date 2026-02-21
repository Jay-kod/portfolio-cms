<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('profile_sections', function (Blueprint $table) {
            $table->string('title')->nullable()->after('section_name');
            $table->json('metadata')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('profile_sections', function (Blueprint $table) {
            $table->dropColumn(['title', 'metadata']);
        });
    }
};
