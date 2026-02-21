<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileSection;
use Illuminate\Http\Request;

class ProfileSectionController extends Controller
{
    public function index()
    {
        return ProfileSection::ordered()->paginate(25);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'content' => 'required|string|max:10000',
            'metadata' => 'nullable|array',
            'display_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $section = ProfileSection::create($validated);
        return response()->json($section, 201);
    }

    public function show(ProfileSection $profileSection)
    {
        return $profileSection;
    }

    public function update(Request $request, ProfileSection $profileSection)
    {
        $validated = $request->validate([
            'section_name' => 'sometimes|string|max:255',
            'title' => 'nullable|string|max:255',
            'content' => 'sometimes|string|max:10000',
            'metadata' => 'nullable|array',
            'display_order' => 'sometimes|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $profileSection->update($validated);
        return $profileSection;
    }

    public function destroy(ProfileSection $profileSection)
    {
        $profileSection->delete();
        return response()->noContent();
    }
}
