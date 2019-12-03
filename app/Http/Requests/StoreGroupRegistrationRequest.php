<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRegistrationRequest extends FormRequest
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
                'register_date'             => 'required|date',
                'attendance_confirm_date'   => 'date|nullable',
                'registration_confirm_date' => 'date|nullable',
                'status_id'                 => 'required|integer|min:1',
                'canceled_at'               => 'date|nullable',
                'arrived_at'                => 'date|nullable',
                'departed_at'               => 'date|nullable',
                'event_id'                  => 'required|integer|min:0',
                'group_id'                  => 'required|integer|min:0',
                'deposit'                   => 'required|numeric|min:0|max:10000',
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
