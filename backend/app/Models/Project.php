<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'project_type',
        'technologies',
        'role',
        'team_size',
        'start_date',
        'end_date',
        'is_ongoing',
        'github_url',
        'live_url',
        'image_url',
        'highlights',
        'is_featured',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'technologies' => 'array',
            'highlights' => 'array',
            'is_ongoing' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('is_featured')->orderByDesc('created_at');
    }
}
