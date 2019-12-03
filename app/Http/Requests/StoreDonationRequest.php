<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
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
                'donor_id'         => 'required|integer|min:0',
                'event_id'         => 'integer|min:0',
                'donation_date'    => 'required|date',
                'payment_date'     => 'required|date',
                'donation_amount'  => 'required|numeric',
                'payment_amount'   => 'required|numeric',
                'payment_idnumber' => 'nullable|numeric|min:0',
                'start_date_only'  => 'date|nullable|before:end_date_only',
                'end_date_only'    => 'date|nullable|after:start_date_only',
                'donation_install' => 'numeric|min:0|nullable',
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
