<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        return Skill::paginate(25);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'proficiency_level' => 'required|integer|min:0|max:100',
            'years_of_experience' => 'required|numeric|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $skill = Skill::create($validated);
        return response()->json($skill, 201);
    }

    public function show(Skill $skill)
    {
        return $skill;
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'category' => 'nullable|string|max:255',
            'proficiency_level' => 'sometimes|integer|min:0|max:100',
            'years_of_experience' => 'sometimes|numeric|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $skill->update($validated);
        return $skill;
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return response()->noContent();
    }
}
