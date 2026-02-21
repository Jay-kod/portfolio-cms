<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PageView extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'path',
        'page_name',
        'ip_address',
        'user_agent',
        'referrer',
        'device_type',
        'browser',
        'country',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get analytics summary for the dashboard.
     */
    public static function getAnalytics(): array
    {
        $now = Carbon::now();

        return [
            'today' => static::whereDate('created_at', $now->toDateString())->count(),
            'yesterday' => static::whereDate('created_at', $now->copy()->subDay()->toDateString())->count(),
            'thisWeek' => static::where('created_at', '>=', $now->copy()->startOfWeek())->count(),
            'thisMonth' => static::where('created_at', '>=', $now->copy()->startOfMonth())->count(),
            'total' => static::count(),
            'uniqueToday' => static::whereDate('created_at', $now->toDateString())
                ->distinct('ip_address')->count('ip_address'),
            'uniqueThisMonth' => static::where('created_at', '>=', $now->copy()->startOfMonth())
                ->distinct('ip_address')->count('ip_address'),
        ];
    }

    /**
     * Get daily view counts for the last N days.
     */
    public static function getDailyViews(int $days = 30): array
    {
        $startDate = Carbon::now()->subDays($days - 1)->startOfDay();

        $views = static::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as views, COUNT(DISTINCT ip_address) as unique_views')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $result = [];
        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i)->toDateString();
            $result[] = [
                'date' => $date,
                'label' => Carbon::parse($date)->format('M d'),
                'views' => $views->has($date) ? $views[$date]->views : 0,
                'unique_views' => $views->has($date) ? $views[$date]->unique_views : 0,
            ];
        }

        return $result;
    }

    /**
     * Get top pages by view count.
     */
    public static function getTopPages(int $limit = 5, int $days = 30): array
    {
        return static::where('created_at', '>=', Carbon::now()->subDays($days))
            ->selectRaw('path, page_name, COUNT(*) as views, COUNT(DISTINCT ip_address) as unique_views')
            ->groupBy('path', 'page_name')
            ->orderByDesc('views')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Get device breakdown.
     */
    public static function getDeviceBreakdown(int $days = 30): array
    {
        return static::where('created_at', '>=', Carbon::now()->subDays($days))
            ->selectRaw("COALESCE(device_type, 'unknown') as device, COUNT(*) as count")
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->get()
            ->toArray();
    }

    /**
     * Get browser breakdown.
     */
    public static function getBrowserBreakdown(int $days = 30): array
    {
        return static::where('created_at', '>=', Carbon::now()->subDays($days))
            ->selectRaw("COALESCE(browser, 'unknown') as browser, COUNT(*) as count")
            ->groupBy('browser')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->toArray();
    }

    /**
     * Get top referrers.
     */
    public static function getTopReferrers(int $limit = 5, int $days = 30): array
    {
        return static::where('created_at', '>=', Carbon::now()->subDays($days))
            ->whereNotNull('referrer')
            ->where('referrer', '!=', '')
            ->selectRaw('referrer, COUNT(*) as count')
            ->groupBy('referrer')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
