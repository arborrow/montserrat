<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateDonationRequest
 */
class UpdateAssetJobRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateAssetJobRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateAssetJobRequest();
    }

    /**
     * @test
     */
    public function authorize(): void
    {
        $actual = $this->subject->authorize();

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function rules(): void
    {
        $actual = $this->subject->rules();

        $this->assertEquals([
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
        ], $actual);
    }

    /**
     * @test
     */
    public function messages(): void
    {
        $actual = $this->subject->messages();

        $this->assertEquals([], $actual);
    }

    // test cases...
}
