<?php

namespace App\Services;

use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;

class ContentSelectorService
{
    public function selectRelevantContent(string $jobTitle, ?string $jobDescription, ?string $companyName): array
    {
        $keywords = $this->extractKeywords($jobTitle . ' ' . $jobDescription . ' ' . $companyName);

        return [
            'skills' => $this->rankSkills($keywords),
            'experiences' => $this->rankExperiences($keywords),
            'projects' => $this->rankProjects($keywords),
        ];
    }

    protected function extractKeywords(string $text): array
    {
        // Simple keyword extraction (can be improved with NLP libraries or AI services)
        $stopWords = ['the', 'and', 'a', 'an', 'in', 'on', 'at', 'for', 'to', 'with', 'by'];
        $words = str_word_count(strtolower($text), 1);
        return array_diff($words, $stopWords);
    }

    protected function rankSkills(array $keywords)
    {
        $skills = Skill::all();
        $scoredSkills = $skills->map(function ($skill) use ($keywords) {
            $score = 0;
            if (in_array(strtolower($skill->name), $keywords)) $score += 10;
            
            if ($skill->tags) {
                foreach ($skill->tags as $tag) {
                    if (in_array(strtolower($tag), $keywords)) $score += 5;
                }
            }

            if ($skill->is_featured) $score += 2;
            $score += $skill->proficiency_level / 10;

            $skill->relevance_score = $score;
            $skill->auto_selected = $score > 15; // Threshold
            return $skill;
        });

        return $scoredSkills->sortByDesc('relevance_score')->values();
    }

    protected function rankExperiences(array $keywords)
    {
        $experiences = Experience::all();
        $scoredExperiences = $experiences->map(function ($exp) use ($keywords) {
            $score = 0;
            $text = strtolower($exp->job_title . ' ' . $exp->description . ' ' . implode(' ', $exp->technologies_used ?? []));
            
            foreach ($keywords as $keyword) {
                if (str_contains($text, $keyword)) $score += 2;
            }

            if ($exp->is_current) $score += 5;
            
            $exp->relevance_score = $score;
            $exp->auto_selected = $score > 5;
            return $exp;
        });

        return $scoredExperiences->sortByDesc('relevance_score')->values();
    }

    protected function rankProjects(array $keywords)
    {
        $projects = Project::all();
        $scoredProjects = $projects->map(function ($proj) use ($keywords) {
            $score = 0;
            $text = strtolower($proj->title . ' ' . $proj->description . ' ' . implode(' ', $proj->technologies ?? []));

            foreach ($keywords as $keyword) {
                if (str_contains($text, $keyword)) $score += 2;
            }

            if ($proj->is_featured) $score += 3;
            if ($proj->project_type === 'Professional') $score += 2;

            $proj->relevance_score = $score;
            $proj->auto_selected = $score > 5;
            return $proj;
        });

        return $scoredProjects->sortByDesc('relevance_score')->values();
    }
}
