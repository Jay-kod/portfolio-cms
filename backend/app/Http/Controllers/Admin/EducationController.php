<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EducationController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Education', [
            'education' => Education::orderBy('start_date', 'desc')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'institution_name' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date|required_if:is_current,false',
            'is_current' => 'boolean',
            'grade' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:5000',
            'achievements' => 'nullable|array',
            'achievements.*' => 'string|max:500',
            'is_active' => 'boolean',
        ]);

        Education::create($validated);

        return redirect()->back()->with('success', 'Education created.');
    }

    public function update(Request $request, Education $education)
    {
        $validated = $request->validate([
            'institution_name' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date|required_if:is_current,false',
            'is_current' => 'boolean',
            'grade' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:5000',
            'achievements' => 'nullable|array',
            'achievements.*' => 'string|max:500',
            'is_active' => 'boolean',
        ]);

        $education->update($validated);

        return redirect()->back()->with('success', 'Education updated.');
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return redirect()->back()->with('success', 'Education deleted.');
    }
}
