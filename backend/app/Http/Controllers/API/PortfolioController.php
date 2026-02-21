<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use App\Models\Education;
use App\Models\Experience;
use App\Models\ProfileSection;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Certification;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function profile(Request $request)
    {
        return ProfileSection::active()->ordered()->paginate($request->input('per_page', 25));
    }

    public function skills(Request $request)
    {
        return Skill::active()->orderBy('proficiency_level', 'desc')->paginate($request->input('per_page', 25));
    }

    public function experiences(Request $request)
    {
        return Experience::active()->ordered()->paginate($request->input('per_page', 25));
    }

    public function projects(Request $request)
    {
        return Project::active()->ordered()->paginate($request->input('per_page', 25));
    }

    public function education(Request $request)
    {
        return Education::active()->orderBy('start_date', 'desc')->paginate($request->input('per_page', 25));
    }

    public function certifications(Request $request)
    {
        return Certification::active()->orderBy('issue_date', 'desc')->paginate($request->input('per_page', 25));
    }

    public function contact(Request $request)
    {
        return ContactInfo::active()->ordered()->paginate($request->input('per_page', 25));
    }

    public function full()
    {
        return response()->json([
            'profile' => ProfileSection::active()->ordered()->get(),
            'skills' => Skill::active()->orderBy('proficiency_level', 'desc')->get(),
            'experiences' => Experience::active()->ordered()->get(),
            'projects' => Project::active()->ordered()->get(),
            'education' => Education::active()->orderBy('start_date', 'desc')->get(),
            'certifications' => Certification::active()->orderBy('issue_date', 'desc')->get(),
            'contact' => ContactInfo::active()->ordered()->get(),
        ]);
    }
}
