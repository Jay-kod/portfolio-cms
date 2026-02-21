<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ResumeGeneration;
use App\Models\ResumeTemplate;
use App\Services\ContentSelectorService;
use App\Services\PdfGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
{
    protected $contentSelector;
    protected $pdfGenerator;

    public function __construct(ContentSelectorService $contentSelector, PdfGeneratorService $pdfGenerator)
    {
        $this->contentSelector = $contentSelector;
        $this->pdfGenerator = $pdfGenerator;
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'job_description' => 'nullable|string|max:5000',
        ]);

        return $this->contentSelector->selectRelevantContent(
            $request->job_title,
            $request->job_description,
            $request->company_name
        );
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'job_description' => 'nullable|string|max:5000',
            'template_id' => 'required|exists:resume_templates,id',
            'selected_skills' => 'nullable|array',
            'selected_skills.*' => 'integer|exists:skills,id',
            'selected_experiences' => 'nullable|array',
            'selected_experiences.*' => 'integer|exists:experiences,id',
            'selected_projects' => 'nullable|array',
            'selected_projects.*' => 'integer|exists:projects,id',
            'selected_education' => 'nullable|array',
            'selected_education.*' => 'integer|exists:education,id',
            'selected_certifications' => 'nullable|array',
            'selected_certifications.*' => 'integer|exists:certifications,id',
            'custom_objective' => 'nullable|string|max:2000',
            'additional_notes' => 'nullable|string|max:2000',
        ]);

        $resume = new ResumeGeneration($validated);
        $resume->user_id = Auth::id(); // Nullable for public guests
        $resume->save();

        return response()->json([
            'message' => 'Resume initialized successfully',
            'token' => $resume->access_token,
            'resume' => $resume
        ], 201);
    }

    public function show($token)
    {
        $resume = ResumeGeneration::where('access_token', $token)->firstOrFail();
        
        if ($resume->isExpired()) {
            return response()->json(['message' => 'Resume link expired'], 410);
        }

        $resume->incrementViews();
        
        $data = $this->loadResumeData($resume);

        return response()->json($data);
    }

    public function download($token)
    {
        $resume = ResumeGeneration::where('access_token', $token)->firstOrFail();
        
        if ($resume->isExpired()) {
            return response()->json(['message' => 'Resume link expired'], 410);
        }

        $resume->incrementDownloads();

        $data = $this->loadResumeData($resume);
        $template = ResumeTemplate::find($resume->template_id);
        
        // Ensure template view exists, fallback to default (using lowercase template name)
        $viewName = strtolower(str_replace(' ', '_', $template->name));
        
        // Generate PDF
        $pdfPath = $this->pdfGenerator->generate($data, $viewName);
        $resume->update(['generated_pdf_path' => $pdfPath]);

        // Sanitize path — ensure it stays within the expected directory
        $resolvedPath = realpath(storage_path('app/' . $pdfPath));
        $allowedBase = realpath(storage_path('app/public/resumes'));

        if (!$resolvedPath || !$allowedBase || !str_starts_with($resolvedPath, $allowedBase)) {
            abort(403, 'Invalid file path.');
        }

        return response()->download($resolvedPath);
    }

    protected function loadResumeData(ResumeGeneration $resume)
    {
        return [
            'meta' => $resume,
            'profile' => \App\Models\ProfileSection::active()->ordered()->get(),
            'skills' => \App\Models\Skill::whereIn('id', $resume->selected_skills ?? [])->get(),
            'experiences' => \App\Models\Experience::whereIn('id', $resume->selected_experiences ?? [])->ordered()->get(),
            'projects' => \App\Models\Project::whereIn('id', $resume->selected_projects ?? [])->ordered()->get(),
            'education' => \App\Models\Education::whereIn('id', $resume->selected_education ?? [])->orderBy('start_date', 'desc')->get(),
            'certifications' => \App\Models\Certification::whereIn('id', $resume->selected_certifications ?? [])->get(),
            'contact' => \App\Models\ContactInfo::forResume()->ordered()->get(),
            'custom_objective' => $resume->custom_objective,
        ];
    }
}
