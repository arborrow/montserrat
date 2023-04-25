<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
            'name' => 'required',
            'location_id' => 'integer|required|min:0',
            'floor' => 'integer|min:0',
            'occupancy' => 'integer|min:0',
            'description' => 'string|nullable',
            'notes' => 'string|nullable',
            'access' => 'string|nullable',
            'type' => 'string|nullable',
            'status' => 'string|nullable',
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
