<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'job_title',
        'company_name',
        'company_location',
        'employment_type',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'achievements',
        'technologies_used',
        'display_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'achievements' => 'array',
            'technologies_used' => 'array',
            'is_current' => 'boolean',
            'is_active' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderByDesc('start_date');
    }
}
