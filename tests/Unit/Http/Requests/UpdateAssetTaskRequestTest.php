<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateDonationRequest
 */
class UpdateAssetTaskRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateAssetTaskRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateAssetTaskRequest;
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
            'id' => 'integer|min:1|required',
            'asset_id' => 'integer|min:0|exists:asset,id|required',
            'title' => 'string|max:250|required',
            'start_date' => 'date|required',
            'scheduled_until_date' => 'date|required',
            'frequency' => 'in:'.implode(',', config('polanco.asset_task_frequency')).'|required',
            'frequency_interval' => 'required|integer|between:1,365',
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

    #[Test]
    public function messages(): void
    {
        $actual = $this->subject->messages();

        $this->assertEquals([], $actual);
    }

    // test cases...
}
