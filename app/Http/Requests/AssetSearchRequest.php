<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetSearchRequest extends FormRequest
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
            'name' => 'string|nullable',
            'asset_type_id' => 'integer|nullable',
            'description' => 'string|nullable',
            'manufacturer' => 'string|nullable',
            'serial_number' => 'string|nullable',
            'year' => 'integer|nullable',
            'location_id' => 'integer|nullable',
            'department_id' => 'integer|nullable',
            'parent_id' => 'integer|nullable',
            'status' => 'string|nullable',
            'remarks' => 'string|nullable',
            'is_active' => 'boolean|nullable',
            'manufacturer_id' => 'integer|nullable',
            'vendor_id' => 'integer|nullable',
            'power_line_voltage' => 'integer|nullable',
            'power_line_voltage_uom_id' => 'integer|nullable',
            'power_phase_voltage' => 'integer|nullable',
            'power_phase_voltage_uom_id' => 'integer|nullable',
            'power_phases' => 'integer|nullable',
            'power_amp' => 'integer|nullable',
            'length' => 'integer|nullable',
            'length_uom_id' => 'integer|nullable',
            'width' => 'integer|nullable',
            'width_uom_id' => 'integer|nullable',
            'height' => 'integer|nullable',
            'height_uom_id' => 'integer|nullable',
            'weight' => 'integer|nullable',
            'weight_uom_id' => 'integer|nullable',
            'capacity' => 'integer|nullable',
            'capacity_uom_id' => 'integer|nullable',
            'purchase_date' => 'date|nullable',
            'purchase_price' => 'numeric|nullable',
            'start_date' => 'date|nullable',
            'end_date' => 'date|nullable',
            'life_expectancy' => 'numeric|nullable',
            'life_expectancy_uom_id' => 'integer|nullable',
            'replacement_id' => 'integer|nullable',
            'warranty_start_date' => 'date|nullable',
            'warranty_end_date' => 'date|nullable',
            'depreciation_start_date' => 'date|nullable',
            'depreciation_end_date' => 'date|nullable',
            'depreciation_type_id' => 'integer|nullable',
            'depreciation_value' => 'numeric|nullable',
            'depreciation_time' => 'numeric|nullable',
            'depreciation_type_id' => 'integer|nullable',
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
