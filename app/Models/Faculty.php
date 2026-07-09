<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Faculty extends Model
{
    protected $primaryKey = 'faculty_id';

    protected $fillable = [
        'full_name', 'gender', 'employment_status', 'academic_rank',
        'educational_attainment', 'professional_license', 'specialization',
        'max_load', 'is_archived',
    ];

    protected function casts(): array
    {
        return [
            'is_archived' => 'boolean',
        ];
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'faculty_id', 'faculty_id');
    }

    public function qualifications(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'faculty_qualifications', 'faculty_id', 'subject_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'faculty_id', 'faculty_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }
}
