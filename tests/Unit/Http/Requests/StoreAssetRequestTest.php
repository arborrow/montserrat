<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreUomRequest
 */
class StoreAssetRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreAssetRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreAssetRequest;
    }

    #[Test]
    public function authorize(): void
    {
        $actual = $this->subject->authorize();

        $this->assertTrue($actual);
    }

    #[Test]
    public function rules(): void
    {
        $actual = $this->subject->rules();

        $this->assertEquals([
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
            'attachment' => 'file|mimes:pdf,doc,docx,zip,jpg,jpeg,png|max:10000|nullable',
            'attachment_description' => 'string|max:200|nullable',
        ], $actual);
    }

    #[Test]
    public function messages(): void
    {
        $actual = $this->subject->messages();

        $this->assertEquals([], $actual);
    }

    // test cases...
}
