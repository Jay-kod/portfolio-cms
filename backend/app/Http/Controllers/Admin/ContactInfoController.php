<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Inertia\Inertia;

class ContactInfoController extends Controller
{
    private const URL_TYPES = ['linkedin', 'github', 'website', 'twitter', 'facebook', 'youtube', 'tiktok', 'instagram', 'reddit', 'medium', 'stackoverflow', 'dribbble', 'behance', 'twitch', 'pinterest'];

    public function index()
    {
        return Inertia::render('Admin/ContactInfo', [
            'contacts' => ContactInfo::ordered()->get(),
        ]);
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

        ContactInfo::create($validated);

        return redirect()->back()->with('success', 'Contact info created.');
    }

    public function update(Request $request, ContactInfo $contactInfo)
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

        $contactInfo->update($validated);

        return redirect()->back()->with('success', 'Contact info updated.');
    }

    public function destroy(ContactInfo $contactInfo)
    {
        $contactInfo->delete();

        return redirect()->back()->with('success', 'Contact info deleted.');
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
