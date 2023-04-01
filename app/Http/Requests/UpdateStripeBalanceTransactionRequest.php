<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStripeBalanceTransactionRequest extends FormRequest
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
            'id' => 'integer|min:1|required',
            'payout_id ' => 'string|nullable',
            'contact_id' => 'integer|min:0',
            'payment_id' => 'integer|min:0',
            'contribution_id' => 'integer|min:1',
            'balance_transaction_id' => 'string|nullable',
            'customer_id' => 'string|nullable',
            'charge_id' => 'string|nullable',
            'name' => 'string|nullable',
            'first_name' => 'string|nullable',
            'last_name' => 'string|nullable',
            'email' => 'email|nullable',
            'phone' => 'string|nullable',
            'zip' => 'alpha_dash|max:12|nullable',
            'description' => 'string|nullable',
            'note' => 'string|nullable',
            'type' => 'string|nullable',
            'cc_last_4 ' => 'integer|min:1000|max:9999|nullable',
            'total_amount' => 'numeric|nullable',
            'fee_amount' => 'numeric|nullable',
            'net_amount' => 'numeric|nullable',
            'payout_date ' => 'date|nullable',
            'reconcile_date ' => 'date|nullable',
            'available_date ' => 'date|nullable',
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
