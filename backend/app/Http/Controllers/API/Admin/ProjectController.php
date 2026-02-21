<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::ordered()->paginate(25);
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

        $project = Project::create($validated);
        return response()->json($project, 201);
    }

    public function show(Project $project)
    {
        return $project;
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
        return $project;
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->noContent();
    }
}
