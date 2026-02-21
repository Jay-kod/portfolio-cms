<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\ContactInfo;
use App\Models\Education;
use App\Models\Experience;
use App\Models\ProfileSection;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SiteSetting;
use Inertia\Inertia;

class PortfolioPageController extends Controller
{
    private function siteName(): string
    {
        return SiteSetting::getValue('site_name', 'jaykod.io');
    }

    public function index()
    {
        return Inertia::render('Portfolio/Index', [
            'profile' => ProfileSection::active()->ordered()->get(),
            'skills' => Skill::active()->orderBy('proficiency_level', 'desc')->take(6)->get(),
            'experiences' => Experience::active()->ordered()->take(3)->get(),
            'projects' => Project::active()->ordered()->take(3)->get(),
            'contact' => ContactInfo::active()->ordered()->get(),
            'meta' => [
                'title' => 'Home',
                'description' => 'Full-stack developer portfolio — explore projects, skills, and experience at ' . $this->siteName(),
            ],
        ]);
    }

    public function about()
    {
        return Inertia::render('Portfolio/About', [
            'profile' => ProfileSection::active()->ordered()->get(),
            'skills' => Skill::active()->orderBy('proficiency_level', 'desc')->get(),
            'experiences' => Experience::active()->ordered()->get(),
            'projects' => Project::active()->ordered()->get(),
            'certifications' => Certification::active()->orderBy('issue_date', 'desc')->get(),
            'education' => Education::orderBy('start_date', 'desc')->get(),
            'meta' => [
                'title' => 'About',
                'description' => 'Learn more about the developer behind ' . $this->siteName() . ' — background, certifications, and journey.',
            ],
        ]);
    }

    public function skills()
    {
        return Inertia::render('Portfolio/Skills', [
            'skills' => Skill::active()->orderBy('proficiency_level', 'desc')->get(),
            'meta' => [
                'title' => 'Skills',
                'description' => 'Technical skills and proficiencies — languages, frameworks, and tools.',
            ],
        ]);
    }

    public function experience()
    {
        return Inertia::render('Portfolio/Experience', [
            'experiences' => Experience::active()->ordered()->get(),
            'education' => Education::active()->orderBy('start_date', 'desc')->get(),
            'certifications' => Certification::active()->orderBy('issue_date', 'desc')->get(),
            'meta' => [
                'title' => 'Experience & Education',
                'description' => 'Professional experience, academic background, and certifications.',
            ],
        ]);
    }

    public function projects()
    {
        return Inertia::render('Portfolio/Projects', [
            'projects' => Project::active()->ordered()->get(),
            'skills' => Skill::active()->orderBy('proficiency_level', 'desc')->get(),
            'meta' => [
                'title' => 'Projects',
                'description' => 'Featured projects and portfolio work — web apps, APIs, and more.',
            ],
        ]);
    }

    public function education()
    {
        return Inertia::render('Portfolio/Education', [
            'education' => Education::active()->orderBy('start_date', 'desc')->get(),
            'certifications' => Certification::active()->orderBy('issue_date', 'desc')->get(),
            'meta' => [
                'title' => 'Education',
                'description' => 'Education background and professional certifications.',
            ],
        ]);
    }

    public function contact()
    {
        return Inertia::render('Portfolio/Contact', [
            'contact' => ContactInfo::active()->ordered()->get(),
            'profile' => ProfileSection::active()->ordered()->get(),
            'meta' => [
                'title' => 'Contact',
                'description' => 'Get in touch — contact information and social links.',
            ],
        ]);
    }
}
