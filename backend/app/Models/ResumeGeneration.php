<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ResumeGeneration extends Model
{
    protected $fillable = [
        'user_id',
        'job_title',
        'company_name',
        'job_description',
        'template_id',
        'selected_skills',
        'selected_experiences',
        'selected_projects',
        'selected_education',
        'selected_certifications',
        'custom_objective',
        'additional_notes',
        'generated_pdf_path',
        'access_token',
        'is_public',
        'views_count',
        'downloads_count',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'selected_skills' => 'array',
            'selected_experiences' => 'array',
            'selected_projects' => 'array',
            'selected_education' => 'array',
            'selected_certifications' => 'array',
            'is_public' => 'boolean',
            'expires_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($resume) {
            if (empty($resume->access_token)) {
                $resume->access_token = Str::random(32);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(ResumeTemplate::class, 'template_id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function incrementDownloads(): void
    {
        $this->increment('downloads_count');
    }
}
