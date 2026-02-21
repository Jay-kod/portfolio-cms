<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeTemplate extends Model
{
    protected $fillable = [
        'name',
        'description',
        'layout_config',
        'styling_config',
        'is_active',
        'thumbnail_url',
    ];

    protected function casts(): array
    {
        return [
            'layout_config' => 'array',
            'styling_config' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function resumeGenerations()
    {
        return $this->hasMany(ResumeGeneration::class, 'template_id');
    }
}
