<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'begin_date' => 'date|nullable',
            'end_date' => 'date|nullable',
            'title' => 'string|nullable',
            'idnumber' => 'string|nullable',
            'event_type_id' => 'integer|nullable',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [];
    }
}
