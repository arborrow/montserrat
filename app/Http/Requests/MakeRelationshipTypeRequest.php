<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakeRelationshipTypeRequest extends FormRequest
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
                'contact_a_id' => 'integer|min:0|required',
                'contact_b_id' => 'integer|min:0|required',
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
