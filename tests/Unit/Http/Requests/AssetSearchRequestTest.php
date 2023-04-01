<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\SearchRequest
 */
class AssetSearchRequestTest extends TestCase
{
    /** @var \App\Http\Requests\AssetSearchRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\AssetSearchRequest();
    }

    /**
     * @test
     */
    public function authorize()
    {
        $actual = $this->subject->authorize();

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function rules()
    {
        $actual = $this->subject->rules();

        $this->assertEquals([
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
        ], $actual);
    }

    /**
     * @test
     */
    public function messages()
    {
        $actual = $this->subject->messages();

        $this->assertEquals([], $actual);
    }

    // test cases...
}
