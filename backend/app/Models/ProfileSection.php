<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileSection extends Model
{
    protected $fillable = [
        'section_name',
        'title',
        'content',
        'metadata',
        'is_active',
        'display_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'metadata' => 'array',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }
}
