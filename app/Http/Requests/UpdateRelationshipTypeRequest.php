<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRelationshipTypeRequest extends FormRequest
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
                'description' => 'required',
                'name_a_b'    => 'required',
                'label_a_b'   => 'required',
                'name_b_a'    => 'required',
                'label_b_a'   => 'required',
                'is_active'   => 'integer|min:0|max:1',
                'is_reserved' => 'integer|min:0|max:1',
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
