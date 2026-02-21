<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SiteSettingsController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/SiteSettings', [
            'settings' => SiteSetting::all(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string|exists:site_settings,key',
            'settings.*.value' => 'nullable|string|max:500',
        ]);

        // Filter out profile image from bulk updates — it has its own endpoint
        $filtered = array_filter($validated['settings'], fn($item) => $item['key'] !== 'site_profile_image');

        DB::transaction(function () use ($filtered) {
            foreach ($filtered as $item) {
                SiteSetting::where('key', $item['key'])->update(['value' => $item['value']]);
            }
        });

        SiteSetting::clearCache();

        return redirect()->back()->with('success', 'Site settings updated successfully.');
    }

    /**
     * Store the profile image as a base64 data URI directly in the database.
     */
    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpeg,jpg,png,webp|max:5120', // 5MB
        ]);

        $file = $request->file('image');
        $mime = $file->getMimeType();
        $base64 = base64_encode(file_get_contents($file->getRealPath()));
        $dataUri = "data:{$mime};base64,{$base64}";

        SiteSetting::where('key', 'site_profile_image')->update(['value' => $dataUri]);
        SiteSetting::clearCache();

        return response()->json(['success' => true, 'image' => $dataUri]);
    }

    /**
     * Remove the profile image from the database.
     */
    public function removeProfileImage()
    {
        SiteSetting::where('key', 'site_profile_image')->update(['value' => '']);
        SiteSetting::clearCache();

        return response()->json(['success' => true]);
    }
}
