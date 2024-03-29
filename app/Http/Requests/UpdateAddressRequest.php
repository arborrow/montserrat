<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
     *
     * TODO: languages and referrals
     */
    public function rules(): array
    {
        return [
            'city' => 'string|max:125|nullable',
            'contact_id' => 'required|integer|min:0',
            'country_id' => 'integer|min:0|nullable',
            'is_primary' => 'boolean|nullable',
            'location_type_id' => 'required|integer|min:0',
            'postal_code' => 'alpha_dash|max:12|nullable',
            'state_province_id' => 'integer|min:0|nullable',
            'street_address' => 'string|max:125|nullable',
            'supplemental_address_1' => 'string|max:125|nullable',
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
