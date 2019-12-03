<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddmeRelationshipTypeRequest extends FormRequest
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
                'contact_id'        => 'integer|min:1|required',
                'relationship_type' => 'required|in:Child,Parent,Husband,Wife,Sibling,Employee,Volunteer,Parishioner,Primary contact,Employer',
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
