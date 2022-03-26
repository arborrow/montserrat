<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgcDonationsRequest extends FormRequest
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
    {   $valid_agc_donation_type = \App\Models\DonationType::active()
            ->whereIn('name', config('polanco.agc_donation_descriptions'))
            ->get();
        $valid_agc_donation_type_ids = $valid_agc_donation_type->modelKeys();
        // dd($valid_agc_donation_type, $valid_agc_donation_type_ids);
        return [
            'donation_type_id' => 'in:'.implode(',', $valid_agc_donation_type_ids).',0|integer|nullable',
            'fiscal_year' => 'integer|nullable',
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
