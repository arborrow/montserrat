<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSquarespaceCustomFormFieldRequest extends FormRequest
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

     //name , custom_form_id , variant_options

    public function rules()
    {
        return [
            'id' => 'integer|min:1|required',
            'form_id' => 'integer|min:0|required',
            'name' => 'string|nullable',
            'sort_order' => 'integer|min:1|nullable',
            'type' => 'string|nullable',
            'variable_name' => 'string|nullable',
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
