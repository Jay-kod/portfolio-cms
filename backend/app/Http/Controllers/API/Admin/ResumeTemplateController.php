<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResumeTemplate;
use Illuminate\Http\Request;

class ResumeTemplateController extends Controller
{
    public function index()
    {
        return ResumeTemplate::active()->paginate(25);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'layout_config' => 'nullable|array',
            'styling_config' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $template = ResumeTemplate::create($validated);
        return response()->json($template, 201);
    }

    public function show(ResumeTemplate $template)
    {
        return $template;
    }

    public function update(Request $request, ResumeTemplate $template)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string|max:2000',
            'layout_config' => 'nullable|array',
            'styling_config' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $template->update($validated);
        return $template;
    }

    public function destroy(ResumeTemplate $template)
    {
        $template->delete();
        return response()->noContent();
    }
}
