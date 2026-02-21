<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    public function index()
    {
        return Certification::paginate(25);
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

        $certification = Certification::create($validated);
        return response()->json($certification, 201);
    }

    public function show(Certification $certification)
    {
        return $certification;
    }

    public function update(Request $request, Certification $certification)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'issuing_organization' => 'sometimes|string|max:255',
            'issue_date' => 'sometimes|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:2000',
            'is_active' => 'boolean',
        ]);

        $certification->update($validated);
        return $certification;
    }

    public function destroy(Certification $certification)
    {
        $certification->delete();
        return response()->noContent();
    }
}
