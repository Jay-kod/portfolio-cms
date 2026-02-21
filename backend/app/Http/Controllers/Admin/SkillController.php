<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SkillController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Skills', [
            'skills' => Skill::all(),
            'categories' => Skill::distinct()->pluck('category')->filter()->values(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'proficiency_level' => 'required|integer|min:0|max:100',
            'years_of_experience' => 'required|numeric|min:0',
            'is_featured' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'is_active' => 'boolean',
        ]);

        Skill::create($validated);

        return redirect()->back()->with('success', 'Skill created.');
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'category' => 'nullable|string|max:255',
            'proficiency_level' => 'sometimes|integer|min:0|max:100',
            'years_of_experience' => 'sometimes|numeric|min:0',
            'is_featured' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'is_active' => 'boolean',
        ]);

        $skill->update($validated);

        return redirect()->back()->with('success', 'Skill updated.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->back()->with('success', 'Skill deleted.');
    }
}
