<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDioceseRequest extends FormRequest
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
    {   // if Twilio is enabled then validate phone numbers otherwise allow strings
        if (null !== config('settings.twilio_sid') && null !== config('settings.twilio_token')) {
            return [
                'organization_name' => 'required',
                'display_name' => 'required',
                'sort_name' => 'required',
                'bishop_id' => 'integer|min:0',
                'email_main' => 'email|nullable',
                'url_main' => 'url|nullable',
                'url_facebook' => 'url|regex:/facebook\\.com\\/.+/i|nullable',
                'url_google' => 'url|regex:/plus\\.google\\.com\\/.+/i|nullable',
                'url_twitter' => 'url|regex:/twitter\\.com\\/.+/i|nullable',
                'url_instagram' => 'url|regex:/instagram\\.com\\/.+/i|nullable',
                'url_linkedin' => 'url|regex:/linkedin\\.com\\/.+/i|nullable',
                'phone_main_phone' => 'phone|nullable',
                'phone_main_fax' => 'phone|nullable',
                'avatar' => 'image|max:5000|nullable',
                'attachment' => 'file|mimes:pdf,doc,docx,zip|max:10000|nullable',
                'attachment_description' => 'string|max:200|nullable',
                'diocese_note' => 'string|nullable',
            ];
        } else {
            return [
                'organization_name' => 'required',
                'display_name' => 'required',
                'sort_name' => 'required',
                'bishop_id' => 'integer|min:0',
                'email_main' => 'email|nullable',
                'url_main' => 'url|nullable',
                'url_facebook' => 'url|regex:/facebook\\.com\\/.+/i|nullable',
                'url_google' => 'url|regex:/plus\\.google\\.com\\/.+/i|nullable',
                'url_twitter' => 'url|regex:/twitter\\.com\\/.+/i|nullable',
                'url_instagram' => 'url|regex:/instagram\\.com\\/.+/i|nullable',
                'url_linkedin' => 'url|regex:/linkedin\\.com\\/.+/i|nullable',
                'phone_main_phone' => 'string|nullable',
                'phone_main_fax' => 'string|nullable',
                'avatar' => 'image|max:5000|nullable',
                'attachment' => 'file|mimes:pdf,doc,docx,zip|max:10000|nullable',
                'attachment_description' => 'string|max:200|nullable',
                'diocese_note' => 'string|nullable',
            ];
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [];
    }
}
