<?php

namespace App\Http\Controllers;

use App\Models\ResumeGeneration;
use App\Models\ResumeTemplate;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Education;
use App\Models\Certification;
use App\Models\ContactInfo;
use App\Models\ProfileSection;
use App\Models\User;
use Inertia\Inertia;

class ResumePageController extends Controller
{
    public function create()
    {
        return Inertia::render('Resume/Create', [
            'templates' => ResumeTemplate::active()->get(),
        ]);
    }

    public function view(string $token)
    {
        $resume = ResumeGeneration::where('access_token', $token)->firstOrFail();

        if ($resume->isExpired()) {
            abort(410, 'Resume link has expired.');
        }

        $resume->incrementViews();

        $admin = User::where('role', 'admin')->first();

        return Inertia::render('Resume/View', [
            'resume' => $resume,
            'profileData' => [
                'name' => $admin?->name ?? 'Portfolio Owner',
            ],
            'selectedSkills' => Skill::whereIn('id', $resume->selected_skills ?? [])->get(),
            'selectedExperiences' => Experience::whereIn('id', $resume->selected_experiences ?? [])->ordered()->get(),
            'selectedProjects' => Project::whereIn('id', $resume->selected_projects ?? [])->ordered()->get(),
            'education' => Education::whereIn('id', $resume->selected_education ?? [])->orderBy('start_date', 'desc')->get(),
            'certifications' => Certification::whereIn('id', $resume->selected_certifications ?? [])->get(),
            'contactItems' => ContactInfo::forResume()->ordered()->get(),
        ]);
    }
}
