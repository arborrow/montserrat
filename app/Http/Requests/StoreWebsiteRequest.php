<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWebsiteRequest extends FormRequest
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
            'website_type' => 'string|in:'.implode(',', config('polanco.website_types')).'|required',
            'url' => 'string|max:250|nullable',
            'description' => 'string|nullable',
            'asset_id' => 'integer|min:1|nullable',
            'contact_id' => 'integer|min:1|nullable',
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
