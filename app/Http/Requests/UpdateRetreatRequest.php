<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRetreatRequest extends FormRequest
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
    {   // dd($this);
        return [
            'idnumber' => ['alpha_dash', 'required', Rule::unique('event')->ignore($this->id)->whereNull('deleted_at')],
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'title' => 'required',
            'innkeeper_id' => 'integer|min:0',
            'assistant_id' => 'integer|min:0',
            'year' => 'integer|min:1990|max:2020',
            'amount' => 'numeric|min:0|max:100000',
            'attending' => 'integer|min:0|max:150',
            'silent' => 'boolean',
            'is_active' => 'boolean',
            'contract' => 'file|mimes:pdf|max:5000|nullable',
            'schedule' => 'file|mimes:pdf|max:5000|nullable',
            'evaluations' => 'file|mimes:pdf|max:10000|nullable',
            'group_photo' => 'image|max:10000|nullable',
            'event_attachment' => 'file|mimes:pdf,doc,docx,zip|max:10000|nullable',
            'event_attachment_description' => 'string|max:200|nullable',
            'max_participants' => 'integer|min:0|max:150',

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
