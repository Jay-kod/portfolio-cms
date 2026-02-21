<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    private const URL_TYPES = ['linkedin', 'github', 'website', 'twitter', 'facebook', 'youtube', 'tiktok', 'instagram', 'reddit', 'medium', 'stackoverflow', 'dribbble', 'behance', 'twitch', 'pinterest'];

    public function index()
    {
        return ContactInfo::ordered()->paginate(25);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:email,phone,linkedin,github,website,twitter,address,facebook,youtube,tiktok,whatsapp,instagram,telegram,discord,snapchat,reddit,medium,stackoverflow,dribbble,behance,twitch,pinterest,skype',
            'value' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'is_primary' => 'boolean',
            'show_on_resume' => 'boolean',
            'is_active' => 'boolean',
            'display_order' => 'nullable|integer|min:0',
        ]);

        $this->validateValueByType($request);

        $contactInfo = ContactInfo::create($validated);
        return response()->json($contactInfo, 201);
    }

    public function show(ContactInfo $contactInfo)
    {
        return $contactInfo;
    }

    public function update(Request $request, ContactInfo $contactInfo)
    {
        $validated = $request->validate([
            'type' => 'sometimes|in:email,phone,linkedin,github,website,twitter,address,facebook,youtube,tiktok,whatsapp,instagram,telegram,discord,snapchat,reddit,medium,stackoverflow,dribbble,behance,twitch,pinterest,skype',
            'value' => 'sometimes|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'is_primary' => 'boolean',
            'is_active' => 'boolean',
            'show_on_resume' => 'boolean',
            'display_order' => 'sometimes|integer|min:0',
        ]);

        $this->validateValueByType($request);

        $contactInfo->update($validated);
        return $contactInfo;
    }

    public function destroy(ContactInfo $contactInfo)
    {
        $contactInfo->delete();
        return response()->noContent();
    }

    private function validateValueByType(Request $request): void
    {
        $type = $request->input('type');
        $rules = [];

        if ($type === 'email') {
            $rules['value'] = 'required|email|max:255';
        } elseif ($type === 'phone' || $type === 'whatsapp') {
            $rules['value'] = ['required', 'string', 'max:30', 'regex:/^[\+]?[\d\s\-\(\)]+$/'];
        } elseif (in_array($type, self::URL_TYPES)) {
            $rules['value'] = 'required|url|max:255';
        }

        if (!empty($rules)) {
            $request->validate($rules);
        }
    }
}
