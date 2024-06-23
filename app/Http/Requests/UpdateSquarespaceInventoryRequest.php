<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSquarespaceInventoryRequest extends FormRequest
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

    //name , custom_form_id , variant_options

    public function rules(): array
    {
        return [
            'id' => 'integer|min:1|required',
            'name' => 'string|nullable',
            'custom_form_id' => 'integer|min:0|required',
            'variant_options' => 'integer|min:0|required',
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
