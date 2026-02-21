<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileSection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileSectionController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/ProfileSections', [
            'sections' => ProfileSection::ordered()->get(),
        ]);
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

        ProfileSection::create($validated);

        return redirect()->back()->with('success', 'Profile section created.');
    }

    public function update(Request $request, ProfileSection $profileSection)
    {
        $validated = $request->validate([
            'section_name' => 'sometimes|string|max:255',
            'title' => 'nullable|string|max:255',
            'content' => 'sometimes|string|max:10000',
            'metadata' => 'nullable|array',
            'display_order' => 'sometimes|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $profileSection->update($validated);

        return redirect()->back()->with('success', 'Profile section updated.');
    }

    public function destroy(ProfileSection $profileSection)
    {
        $profileSection->delete();

        return redirect()->back()->with('success', 'Profile section deleted.');
    }
}
