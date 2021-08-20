<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonationSearchRequest extends FormRequest
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
            'donation_date_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'donation_amount_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'start_date_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'end_date_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'donation_install_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'donation_date' => 'date|nullable',
            'start_date' => 'date|nullable',
            'end_date' => 'date|nullable',
            'donation_description' => 'string|nullable',
            'event_id' => 'integer|nullable',
            'donation_amount' => 'numeric|nullable',
            'donation_install' => 'numeric|nullable',
            'notes' => 'string|nullable',
            'terms' => 'string|nullable',
            'donation_thank_you' => 'string|nullable',
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
