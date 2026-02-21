<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResumeTemplate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResumeTemplateController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Templates', [
            'templates' => ResumeTemplate::all(),
        ]);
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

        ResumeTemplate::create($validated);

        return redirect()->back()->with('success', 'Template created.');
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

        return redirect()->back()->with('success', 'Template updated.');
    }

    public function destroy(ResumeTemplate $template)
    {
        $template->delete();

        return redirect()->back()->with('success', 'Template deleted.');
    }
}
