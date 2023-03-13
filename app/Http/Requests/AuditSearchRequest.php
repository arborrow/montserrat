<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuditSearchRequest extends FormRequest
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
            'created_at_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'created_at' => 'datetime|nullable',
            'user_id' => 'integer|nullable',
            'auditable_id' => 'integer|nullable',
            'event' => 'string|nullable',
            'auditable_type' => 'string|nullable',
            'old_values' => 'string|nullable',
            'new_values' => 'string|nullable',
            'url' => 'string|nullable',
            'tags' => 'string|nullable',
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
