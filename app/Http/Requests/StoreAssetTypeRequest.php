<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetTypeRequest extends FormRequest
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
            'label' => 'string|max:125|required',
            'name' => 'string|max:125|nullable',
            'description' => 'string|nullable',
            'is_active' => 'boolean|nullable',
            'parent_asset_type_id' => 'integer|min:0|nullable',
            'remember_token' => 'string|nullable',
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
