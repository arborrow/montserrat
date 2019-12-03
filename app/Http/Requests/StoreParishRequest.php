<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParishRequest extends FormRequest
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
            'organization_name' => 'required',
            'diocese_id' => 'integer|min:0',
            'pastor_id' => 'integer|min:0',
            'parish_email_main' => 'email|nullable',
            'url_main' => 'url|nullable',
            'url_facebook' => 'url|regex:/facebook\\.com\\/.+/i|nullable',
            'url_google' => 'url|regex:/plus\\.google\\.com\\/.+/i|nullable',
            'url_twitter' => 'url|regex:/twitter\\.com\\/.+/i|nullable',
            'url_instagram' => 'url|regex:/instagram\\.com\\/.+/i|nullable',
            'url_linkedin' => 'url|regex:/linkedin\\.com\\/.+/i|nullable',
            'phone_main_phone' => 'phone|nullable',
            'phone_main_fax' => 'phone|nullable',
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
