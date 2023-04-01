<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'touched_at' => 'required|date',
            'target_id' => 'required|integer|min:0',
            'assignee_id' => 'required|integer|min:0',
            'creator_id' => 'required|integer|min:0',
            'activity_type_id' => 'required|integer|min:1',
            'status_id' => 'required|integer|min:0',
            'priority_id' => 'required|integer|min:0',
            'medium_id' => 'required|integer|min:1',
            'duration' => 'integer|min:0',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [];
    }
}
