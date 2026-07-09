<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'year_level' => 'required|integer|min:1|max:6',
            'student_count' => 'required|integer|min:0',
            'semester' => 'required|in:1st,2nd,summer',
            'academic_year' => 'required|string|max:20',
        ];
    }
}
