<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        return Experience::ordered()->paginate(25);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date|required_if:is_current,false',
            'is_current' => 'boolean',
            'employment_type' => 'required|in:Full-time,Part-time,Contract,Freelance',
            'description' => 'nullable|string|max:5000',
            'achievements' => 'nullable|array',
            'achievements.*' => 'string|max:500',
            'technologies_used' => 'nullable|array',
            'technologies_used.*' => 'string|max:100',
            'is_active' => 'boolean',
        ]);

        $experience = Experience::create($validated);
        return response()->json($experience, 201);
    }

    public function show(Experience $experience)
    {
        return $experience;
    }

    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'job_title' => 'sometimes|string|max:255',
            'company_name' => 'sometimes|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date|after_or_equal:start_date|required_if:is_current,false',
            'is_current' => 'boolean',
            'employment_type' => 'sometimes|in:Full-time,Part-time,Contract,Freelance',
            'description' => 'nullable|string|max:5000',
            'achievements' => 'nullable|array',
            'achievements.*' => 'string|max:500',
            'technologies_used' => 'nullable|array',
            'technologies_used.*' => 'string|max:100',
            'display_order' => 'sometimes|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $experience->update($validated);
        return $experience;
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return response()->noContent();
    }
}
