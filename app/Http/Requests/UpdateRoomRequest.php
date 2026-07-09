<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_number' => 'required|string|max:50',
            'building' => 'nullable|string|max:255',
            'capacity' => 'required|integer|min:1',
            'room_type' => 'required|in:lecture,lab',
        ];
    }
}
