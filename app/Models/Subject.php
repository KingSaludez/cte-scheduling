<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $fillable = [
        'code', 'title', 'units', 'lecture_hours', 'lab_hours',
        'year_level', 'semester', 'program', 'prerequisites', 'is_archived',
    ];

    protected function casts(): array
    {
        return [
            'is_archived' => 'boolean',
        ];
    }

    public function qualifiedFaculties(): BelongsToMany
    {
        return $this->belongsToMany(Faculty::class, 'faculty_qualifications', 'subject_id', 'faculty_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }
}
