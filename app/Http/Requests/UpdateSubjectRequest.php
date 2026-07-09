<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:20|unique:subjects,code,' . $this->route('subject'),
            'title' => 'required|string|max:255',
            'units' => 'required|numeric|min:0.5|max:15',
            'lecture_hours' => 'required|integer|min:0',
            'lab_hours' => 'required|integer|min:0',
            'year_level' => 'required|integer|min:1|max:6',
            'semester' => 'required|in:1st,2nd,summer',
            'program' => 'nullable|string|max:255',
            'prerequisites' => 'nullable|string|max:500',
        ];
    }
}
