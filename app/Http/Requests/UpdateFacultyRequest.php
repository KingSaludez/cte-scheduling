<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFacultyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'gender' => 'nullable|in:male,female',
            'employment_status' => 'required|in:full-time,part-time',
            'academic_rank' => 'nullable|string|max:255',
            'educational_attainment' => 'nullable|string|max:255',
            'professional_license' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'qualifications' => 'nullable|array',
            'qualifications.*' => 'exists:subjects,id',
        ];
    }
}
