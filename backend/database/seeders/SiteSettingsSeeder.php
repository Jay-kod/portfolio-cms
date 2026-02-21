<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'site_name',
                'value' => 'jaykod.io',
                'label' => 'Site Name',
                'type' => 'text',
            ],
            [
                'key' => 'site_tagline',
                'value' => "Jay's digital playground",
                'label' => 'Site Tagline',
                'type' => 'text',
            ],
            [
                'key' => 'site_icon_letter',
                'value' => 'JK',
                'label' => 'Website Logo Initials',
                'type' => 'text',
            ],
            [
                'key' => 'site_footer_text',
                'value' => 'Crafted with love',
                'label' => 'Footer Text',
                'type' => 'text',
            ],
            [
                'key' => 'site_profile_image',
                'value' => '',
                'label' => 'Developer Profile Photo URL',
                'type' => 'text',
            ],
            [
                'key' => 'google_analytics_id',
                'value' => '',
                'label' => 'Google Analytics Measurement ID',
                'type' => 'text',
            ],
            // Theme colors
            [
                'key' => 'theme_bg_primary',
                'value' => '#0a0a0a',
                'label' => 'Background Primary',
                'type' => 'color',
            ],
            [
                'key' => 'theme_bg_secondary',
                'value' => '#111111',
                'label' => 'Background Secondary',
                'type' => 'color',
            ],
            [
                'key' => 'theme_bg_tertiary',
                'value' => '#1a1a1a',
                'label' => 'Background Tertiary',
                'type' => 'color',
            ],
            [
                'key' => 'theme_accent',
                'value' => '#00ff88',
                'label' => 'Accent Color',
                'type' => 'color',
            ],
            [
                'key' => 'theme_text_primary',
                'value' => '#ffffff',
                'label' => 'Text Primary',
                'type' => 'color',
            ],
            [
                'key' => 'theme_text_secondary',
                'value' => '#6b7280',
                'label' => 'Text Secondary',
                'type' => 'color',
            ],
            [
                'key' => 'theme_border',
                'value' => '#1f1f1f',
                'label' => 'Border Color',
                'type' => 'color',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
