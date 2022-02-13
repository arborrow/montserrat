<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetJobRequest extends FormRequest
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
            'asset_task_id' => 'integer|min:0|exists:asset_task,id|required',
            'assigned_to_id' => 'integer|min:0|exists:contact,id|required',
            'scheduled_date' => 'date|required',
            'start_date' => 'date|nullable',
            'end_date' => 'date|nullable',
            'status' => 'in:'.implode(',', config('polanco.asset_job_status')).'|required',
            'actual_labor' => 'numeric|min:0|nullable',
            'actual_labor_cost' => 'numeric|min:0|nullable',
            'additional_materials' => 'string|nullable',
            'actual_material_cost' => 'numeric|min:0|nullable',
            'note' => 'string|nullable',
            'tag' => 'string|nullable',
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
