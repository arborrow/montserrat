<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAssetRequest extends FormRequest
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
            'name' => 'string|max:250|required',
            'asset_type_id' => 'integer|min:0|exists:asset_type,id|required',
            'description' => 'string|nullable',
            'manufacturer' => 'string|nullable',
            'model' => 'string|nullable',
            'serial_number' => 'string|nullable',
            'year' => 'integer|nullable',
            'location_id' => 'integer|min:0|exists:locations,id|nullable',
            'department_id' => 'integer|min:0|nullable',
            'parent_id' => 'integer|min:0|exists:asset,id|nullable',
            'status' => 'string|nullable',
            'remarks' => 'string|nullable',
            'is_active' => 'boolean|nullable',
            'manufacturer_id' => 'integer|min:0|exists:contact,id|nullable',
            'vendor_id' => 'integer|min:0|exists:contact,id|nullable',
            'power_line_voltage' => 'numeric|nullable',
            'power_line_voltage_uom_id' => 'integer|min:0|exists:uom,id|nullable',
            'power_line_phase_voltage' => 'numeric|nullable',
            'power_line_phase_voltage_uom_id' => 'integer|min:0|exists:uom,id|nullable',
            'power_phases' => 'numeric|nullable',
            'power_amp' => 'numeric|nullable',
            'power_amp_uom_id' => 'integer|min:0|exists:uom,id|nullable',
            'length' => 'numeric|nullable',
            'length_uom_id' => 'integer|min:0|exists:uom,id|nullable',
            'width' => 'numeric|nullable',
            'width_uom_id' => 'integer|min:0|exists:uom,id|nullable',
            'height' => 'numeric|nullable',
            'height_uom_id' => 'integer|min:0|exists:uom,id|nullable',
            'weight' => 'numeric|nullable',
            'weight_uom_id' => 'integer|min:0|exists:uom,id|nullable',
            'capacity' => 'numeric|nullable',
            'capacity_uom_id' => 'integer|min:0|exists:uom,id|nullable',
            'purchase_date' => 'date|nullable',
            'purchase_price' => 'numeric|nullable',
            'life_expectancy' => 'numeric|nullable',
            'life_expectancy_uom_id' => 'integer|min:0|exists:uom,id|nullable',
            'start_date' => 'date|nullable',
            'end_date' => 'date|after:start_date|nullable',
            'replacement_id' => 'integer|min:0|exists:asset,id|nullable',
            'warranty_start_date' => 'date|nullable',
            'warranty_end_date' => 'date|after:warranty_start_date|nullable',
            'depreciation_start_date' => 'date|nullable',
            'depreciation_end_date' => 'date|after:depreciation_start_date|nullable',
            'depreciation_type_id' => 'integer|min:0|nullable',
            'depreciation_rate' => 'numeric|nullable',
            'depreciation_value' => 'numeric|nullable',
            'depreciation_time' => 'numeric|nullable',
            'depreciation_time_uom_id' => 'integer|min:0|exists:uom,id|nullable',
            'asset_photo' => 'image|max:10000|nullable',
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
