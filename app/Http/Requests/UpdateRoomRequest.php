<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
            'name' => 'required',
            'location_id' => 'integer|min:0',
            'floor' => 'integer|min:0',
            'occupancy' => 'integer|min:0',
            'description' => 'string|nullable',
            'notes' => 'string|nullable',
            'access' => 'string|nullable',
            'type' => 'string|nullable',
            'status' => 'string|nullable',
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
        $actual = $this->subject->messages();

        $this->assertEquals([], $actual);

    }
}
