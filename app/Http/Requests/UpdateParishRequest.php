<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateParishRequest extends FormRequest
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
    {   // if Twilio is enabled then validate phone numbers otherwise allow strings
        if (null !== config('settings.twilio_sid') && null !== config('settings.twilio_token')) {
            return [
                'organization_name' => 'required',
                'display_name' => 'required',
                'sort_name' => 'required',
                'diocese_id' => 'integer|min:0',
                'pastor_id' => 'integer|min:0',
                'email_primary' => 'email|nullable',
                'url_main' => 'url|nullable',
                'url_facebook' => 'url|regex:/facebook\\.com\\/.+/i|nullable',
                'url_google' => 'url|regex:/plus\\.google\\.com\\/.+/i|nullable',
                'url_twitter' => 'url|regex:/twitter\\.com\\/.+/i|nullable',
                'url_instagram' => 'url|regex:/instagram\\.com\\/.+/i|nullable',
                'url_linkedin' => 'url|regex:/linkedin\\.com\\/.+/i|nullable',
                'avatar' => 'image|max:5000|nullable',
                'attachment' => 'file|mimes:pdf,doc,docx,zip|max:10000|nullable',
                'attachment_description' => 'string|max:200|nullable',
                'phone_main_phone' => 'phone|nullable',
                'phone_main_fax' => 'phone|nullable',
                'parish_email_main' => 'email|nullable',
                'parish_note' => 'string|nullable',
            ];
        } else {
            return [
                'organization_name' => 'required',
                'display_name' => 'required',
                'sort_name' => 'required',
                'diocese_id' => 'integer|min:0',
                'pastor_id' => 'integer|min:0',
                'email_primary' => 'email|nullable',
                'url_main' => 'url|nullable',
                'url_facebook' => 'url|regex:/facebook\\.com\\/.+/i|nullable',
                'url_google' => 'url|regex:/plus\\.google\\.com\\/.+/i|nullable',
                'url_twitter' => 'url|regex:/twitter\\.com\\/.+/i|nullable',
                'url_instagram' => 'url|regex:/instagram\\.com\\/.+/i|nullable',
                'url_linkedin' => 'url|regex:/linkedin\\.com\\/.+/i|nullable',
                'avatar' => 'image|max:5000|nullable',
                'attachment' => 'file|mimes:pdf,doc,docx,zip|max:10000|nullable',
                'attachment_description' => 'string|max:200|nullable',
                'phone_main_phone' => 'string|nullable',
                'phone_main_fax' => 'string|nullable',
                'parish_email_main' => 'email|nullable',
                'parish_note' => 'string|nullable',
            ];
        }
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
