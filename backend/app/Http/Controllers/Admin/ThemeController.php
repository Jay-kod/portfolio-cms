<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ThemeController extends Controller
{
    /**
     * Theme color keys that this controller manages.
     */
    private const THEME_KEYS = [
        'theme_bg_primary',
        'theme_bg_secondary',
        'theme_bg_tertiary',
        'theme_accent',
        'theme_text_primary',
        'theme_text_secondary',
        'theme_border',
    ];

    public function index()
    {
        $settings = SiteSetting::whereIn('key', self::THEME_KEYS)->get();

        return Inertia::render('Admin/ThemeSettings', [
            'themeSettings' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string|in:' . implode(',', self::THEME_KEYS),
            'settings.*.value' => 'required|string|regex:/^#[0-9a-fA-F]{6}$/',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['settings'] as $item) {
                SiteSetting::where('key', $item['key'])->update(['value' => $item['value']]);
            }
        });

        SiteSetting::clearCache();

        return redirect()->back()->with('success', 'Theme colors updated successfully.');
    }

    public function reset()
    {
        $defaults = [
            'theme_bg_primary' => '#0a0a0a',
            'theme_bg_secondary' => '#111111',
            'theme_bg_tertiary' => '#1a1a1a',
            'theme_accent' => '#00ff88',
            'theme_text_primary' => '#ffffff',
            'theme_text_secondary' => '#6b7280',
            'theme_border' => '#1f1f1f',
        ];

        DB::transaction(function () use ($defaults) {
            foreach ($defaults as $key => $value) {
                SiteSetting::where('key', $key)->update(['value' => $value]);
            }
        });

        SiteSetting::clearCache();

        return redirect()->back()->with('success', 'Theme reset to defaults.');
    }
}
