<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'label',
        'type',
    ];

    /**
     * Get a setting value by key, with optional default.
     */
    public static function getValue(string $key, ?string $default = null): ?string
    {
        $all = static::allAsArray();
        return $all[$key] ?? $default;
    }

    /**
     * Set a setting value by key.
     */
    public static function setValue(string $key, ?string $value): void
    {
        static::where('key', $key)->update(['value' => $value]);
        static::clearCache();
    }

    /**
     * Get all settings as key => value array (cached for 1 hour).
     */
    public static function allAsArray(): array
    {
        return Cache::remember('site_settings_all', 3600, function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Get theme color settings (cached for 1 hour).
     */
    public static function themeColors(): array
    {
        return Cache::remember('site_settings_theme', 3600, function () {
            return static::where('key', 'like', 'theme_%')->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Clear all setting caches.
     */
    public static function clearCache(): void
    {
        Cache::forget('site_settings_all');
        Cache::forget('site_settings_theme');
        Cache::forget('social_links');
    }
}
