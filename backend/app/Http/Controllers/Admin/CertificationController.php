<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CertificationController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Certifications', [
            'certifications' => Certification::orderBy('issue_date', 'desc')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:2000',
            'is_active' => 'boolean',
        ]);

        Certification::create($validated);

        return redirect()->back()->with('success', 'Certification created.');
    }

    public function update(Request $request, Certification $certification)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:2000',
            'is_active' => 'boolean',
        ]);

        $certification->update($validated);

        return redirect()->back()->with('success', 'Certification updated.');
    }

    public function destroy(Certification $certification)
    {
        $certification->delete();

        return redirect()->back()->with('success', 'Certification deleted.');
    }
}
