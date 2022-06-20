<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSquarespaceContributionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'integer|min:1|required',
            'contact_id' => 'integer|min:0|required',
            'event_id' => 'integer|min:1|nullable',
            'couple_contact_id' => 'integer|min:0|nullable',
            'name' => 'string|nullable',
            'first_name' => 'string|nullable',
            'middle_name' => 'string|nullable',
            'last_name' => 'string|nullable',
            'nick_name' => 'string|nullable',
            'email' => 'email|nullable',
            'address_street' => 'string|nullable',
            'address_supplemental' => 'string|nullable',
            'address_city' => 'string|nullable',
            'address_state' => 'integer|min:0|nullable',
            'address_zip' => 'alpha_dash|max:12|nullable',
            'address_country' => 'integer|min:0|nullable',
            'phone' => 'phone|nullable',
            'retreat_description' => 'string|nullable',
            'offering_type' => 'string|nullable',
            'amount' => 'numeric|nullable',
            'fund' => 'string|nullable',
            'idnumber' => 'string|nullable',
            'comments' => 'string|nullable',
            'is_processed' => 'boolean',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
