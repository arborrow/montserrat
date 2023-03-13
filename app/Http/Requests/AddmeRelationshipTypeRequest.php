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
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'relationship_type_name' => 'required|in:Child,Parent,Husband,Wife,Sibling,Employee,Volunteer,Parishioner,Primary contact,Employer,Diocese,Parish,Deacon,Priest,Board member',
            'contact_id' => 'integer|min:1|required',
            'relationship_filter_alternate_name' => 'string|nullable',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [];
    }
}
