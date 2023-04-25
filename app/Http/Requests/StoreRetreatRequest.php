<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRetreatRequest extends FormRequest
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
            'idnumber' => 'alpha_dash|required|unique:event,idnumber',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'title' => 'required',
            'innkeeper_id' => 'integer|min:0',
            'assistant_id' => 'integer|min:0',
            'year' => 'integer|min:1990|max:2020',
            'amount' => 'numeric|min:0|max:100000',
            'attending' => 'integer|min:0|max:150',
            'silent' => 'boolean',
            'is_active' => 'boolean',
            'max_participants' => 'integer|min:0|max:150',
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
