<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
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
            'donor_id' => 'required|integer|min:0',
            'event_id' => 'integer|min:0',
            'donation_date' => 'required|date',
            'payment_date' => 'required|date',
            'donation_amount' => 'required|numeric',
            'payment_amount' => 'required|numeric',
            'payment_idnumber' => 'nullable|numeric|min:0',
            'start_date' => 'date|nullable|before:end_date',
            'end_date' => 'date|nullable|after:start_date',
            'donation_install' => 'numeric|min:0|nullable',
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
