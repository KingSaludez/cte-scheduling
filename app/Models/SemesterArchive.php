<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemesterArchive extends Model
{
    protected $fillable = [
        'academic_year', 'semester', 'archived_at', 'data',
    ];

    protected function casts(): array
    {
        return [
            'archived_at' => 'datetime',
            'data' => 'array',
        ];
    }
}
