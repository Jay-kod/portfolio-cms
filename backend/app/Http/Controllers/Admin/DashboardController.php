<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\ContactInfo;
use App\Models\Education;
use App\Models\Experience;
use App\Models\PageView;
use App\Models\ProfileSection;
use App\Models\Project;
use App\Models\ResumeGeneration;
use App\Models\SiteSetting;
use App\Models\Skill;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::allAsArray();
        $bio = ProfileSection::where('section_name', 'bio')->first();
        $objective = ProfileSection::where('section_name', 'objective')->first();

        return Inertia::render('Admin/Dashboard', [
            'skillsCount' => Skill::count(),
            'experiencesCount' => Experience::count(),
            'projectsCount' => Project::count(),
            'resumesCount' => ResumeGeneration::count(),
            'educationCount' => Education::count(),
            'certificationsCount' => Certification::count(),
            'contactsCount' => ContactInfo::count(),
            'profileSectionsCount' => ProfileSection::count(),
            'recentResumes' => ResumeGeneration::latest()->take(5)->get(),
            'siteName' => $settings['site_name'] ?? '',
            'siteTagline' => $settings['site_tagline'] ?? '',
            'siteProfileImage' => $settings['site_profile_image'] ?? '',
            'siteIconLetter' => $settings['site_icon_letter'] ?? '',
            'bio' => $bio?->content ?? '',
            'bioId' => $bio?->id,
            'objective' => $objective?->content ?? '',
            'objectiveId' => $objective?->id,
            'featuredSkills' => Skill::where('is_featured', true)->orderBy('proficiency_level', 'desc')->take(6)->get(['id', 'name', 'category', 'proficiency_level']),
            'recentProjects' => Project::where('is_active', true)->latest()->take(3)->get(['id', 'title', 'project_type', 'is_featured']),
            // Analytics
            'analytics' => PageView::getAnalytics(),
            'dailyViews' => PageView::getDailyViews(30),
            'topPages' => PageView::getTopPages(5, 30),
            'deviceBreakdown' => PageView::getDeviceBreakdown(30),
            'browserBreakdown' => PageView::getBrowserBreakdown(30),
            'topReferrers' => PageView::getTopReferrers(5, 30),
        ]);
    }
}
