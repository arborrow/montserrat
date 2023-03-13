<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentSearchRequest extends FormRequest
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
            'payment_date_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'payment_amount_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'payment_date' => 'date|nullable',
            'payment_amount' => 'numeric|nullable',
            'payment_description' => 'string|nullable',
            'cknumber' => 'numeric|nullable',
            'ccnumber' => 'numeric|nullable',
            'note' => 'string|nullable',
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
