<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSquarespaceOrderRequest extends FormRequest
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
            'event_id' => 'integer|min:1|required',
            'couple_contact_id' => 'integer|min:0|nullable',

            'title' => 'integer|min:0|nullable',
            'name' => 'string|nullable',
            'first_name' => 'string|nullable',
            'middle_name' => 'string|nullable',
            'last_name' => 'string|nullable',
            'nick_name' => 'string|nullable',
            'email' => 'email|nullable',
            'mobile_phone' => 'phone|nullable',
            'home_phone' => 'phone|nullable',
            'work_phone' => 'phone|nullable',
            'address_street' => 'string|nullable',
            'address_supplemental' => 'string|nullable',
            'address_city' => 'string|nullable',
            'address_state' => 'integer|min:0|nullable',
            'address_zip' => 'alpha_dash|max:12|nullable',
            'address_country' => 'integer|min:0|nullable',
            'emergency_contact' => 'string|max:100|nullable',
            'emergency_contact_phone' => 'string|nullable',
            'emergency_contact_relationship' => 'string|max:100|nullable',
            'dietary' => 'string|nullable',
            'room_preference' => 'string|nullable',
            'preferred_language' => 'string|nullable',
            'date_of_birth' => 'date|nullable',
            'parish_id' => 'integer|min:0|nullable',
            'parish' => 'string|nullable',
            'comments' => 'string|nullable',
            'couple_title' => 'integer|min:0|nullable',
            'couple_name' => 'string|nullable',
            'couple_first_name' => 'string|nullable',
            'couple_middle_name' => 'string|nullable',
            'couple_last_name' => 'string|nullable',
            'couple_nick_name' => 'string|nullable',
            'couple_email' => 'email|nullable',
            'couple_mobile_phone' => 'phone|nullable',
            'couple_emergency_contact' => 'string|max:100|nullable',
            'couple_emergency_contact_phone' => 'string|nullable',
            'couple_emergency_contact_relationship' => 'string|max:100|nullable',
            'couple_dietary' => 'string|nullable',
            'couple_date_of_birth' => 'date|nullable',
            'deposit_amount' => 'numeric|nullable',
            'gift_certificate_number' => 'string|nullable',
            'gift_certificate_retreat' => 'string|nullable',
            'additional_names_and_phone_numbers' => 'string|nullable',
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
