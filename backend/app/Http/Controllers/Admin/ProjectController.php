<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Projects', [
            'projects' => Project::ordered()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'project_type' => 'required|in:Personal,Professional,Open Source,Academic',
            'role' => 'nullable|string|max:255',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:100',
            'highlights' => 'nullable|array',
            'highlights.*' => 'string|max:500',
            'github_url' => 'nullable|url|max:255',
            'live_url' => 'nullable|url|max:255',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        Project::create($validated);

        return redirect()->back()->with('success', 'Project created.');
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string|max:5000',
            'project_type' => 'sometimes|in:Personal,Professional,Open Source,Academic',
            'role' => 'nullable|string|max:255',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:100',
            'highlights' => 'nullable|array',
            'highlights.*' => 'string|max:500',
            'github_url' => 'nullable|url|max:255',
            'live_url' => 'nullable|url|max:255',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $project->update($validated);

        return redirect()->back()->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->back()->with('success', 'Project deleted.');
    }
}
