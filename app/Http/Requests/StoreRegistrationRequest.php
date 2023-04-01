<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
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
            'register_date' => 'required|date',
            'attendance_confirm_date' => 'date|nullable',
            'registration_confirm_date' => 'date|nullable',
            'canceled_at' => 'date|nullable',
            'arrived_at' => 'date|nullable',
            'departed_at' => 'date|nullable',
            'event_id' => 'required|integer|min:1',
            'status_id' => 'required|integer|min:1',
            'contact_id' => 'required|integer|min:1',
            'deposit' => 'required|numeric|min:0|max:10000',
            'num_registrants' => 'integer|min:0|max:99|nullable',
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
