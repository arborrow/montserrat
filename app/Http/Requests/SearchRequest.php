<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'prefix_id' => 'integer|nullable',
            'first_name' => 'string|nullable',
            'middle_name' => 'string|nullable',
            'last_name' => 'string|nullable',
            'suffix_id' => 'integer|nullable',
            'nick_name' => 'string|nullable',
            'display_name' => 'string|nullable',
            'sort_name' => 'string|nullable',
            'contact_type' => 'integer|nullable',
            'subcontact_type' => 'integer|nullable',
            'has_avatar' => 'integer|nullable',
            'has_attachment' => 'integer|nullable',
            'attachment_description' => 'string|nullable',
            'phone' => 'string|nullable',
            'do_not_phone' => 'boolean|nullable',
            'do_not_sms' => 'boolean|nullable',
            'email' => 'string|nullable',
            'do_not_email' => 'boolean|nullable',
            'street_address' => 'string|nullable',
            'city' => 'string|nullable',
            'state_province_id' => 'integer|nullable',
            'postal_code' => 'string|nullable',
            'country_id' => 'integer|nullable',
            'do_not_mail' => 'boolean|nullable',
            'url' => 'string|nullable',
            'emergency_contact_name' => 'string|nullable',
            'emergency_contact_relationship' => 'string|nullable',
            'emergency_contact_phone' => 'string|nullable',
            'gender_id' => 'integer|nullable',
            'birth_date' => 'date|nullable',
            'religion_id' => 'integer|nullable',
            'occupation_id' => 'integer|nullable',
            'parish_id' => 'integer|nullable',
            'ethnicity_id' => 'integer|nullable',
            'languages' => 'array|nullable',
            'preferred_language_id' => 'integer|nullable',
            'referrals' => 'array|nullable',
            'deceased_date' => 'date|nullable',
            'is_deceased' => 'boolean|nullable',
            'note_health' => 'string|nullable',
            'note_dietary' => 'string|nullable',
            'note_general' => 'string|nullable',
            'note_room_preference' => 'string|nullable',
            'touchpoint_notes' => 'string|nullable',
            'touched_at' => 'date|nullable',
            'groups' => 'array|nullable',
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
