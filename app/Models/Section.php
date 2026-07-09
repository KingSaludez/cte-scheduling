<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $fillable = [
        'name', 'year_level', 'student_count', 'semester', 'academic_year', 'is_archived',
    ];

    protected function casts(): array
    {
        return [
            'is_archived' => 'boolean',
        ];
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
