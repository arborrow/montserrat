<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreUomRequest
 */
class StoreAssetTaskRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreAssetTaskRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreAssetTaskRequest();
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
          'asset_id' => 'integer|min:0|exists:asset,id|required',
          'title' => 'string|max:250|required',
          'start_date' => 'date|required',
          'scheduled_until_date' => 'date|required',
          'frequency_interval' => 'integer|nullable',
          'frequency' => 'in:'.implode(',', config('polanco.asset_task_frequency')).'|required',
          'frequency_month' => 'integer|nullable',
          'frequency_day' => 'integer|nullable',
          'frequency_time' => 'date_format:H:i|nullable',
          'description' => 'string|nullable',
          'priority_id' => 'in:'.implode(',', config('polanco.priority')).'|required',
          'needed_labor_minutes' => 'integer|nullable',
          'estimated_labor_cost' => 'numeric|min:0|nullable',
          'needed_material' => 'string|nullable',
          'estimated_material_cost' => 'numeric|min:0|nullable',
          'vendor_id' => 'integer|min:0|exists:contact,id|nullable',
          'category' => 'string|nullable',
          'tag' => 'string|nullable',
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
