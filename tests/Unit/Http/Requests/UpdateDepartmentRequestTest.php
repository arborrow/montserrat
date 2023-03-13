<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateDonationRequest
 */
class UpdateDepartmentRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateDepartmentRequest * */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateDepartmentRequest();
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
            'id' => 'integer|min:1|required',
            'name' => 'string|required',
            'label' => 'string|nullable',
            'description' => 'string|nullable',
            'notes' => 'string|nullable',
            'parent_id' => 'integer|nullable',
            'is_active' => 'boolean|nullable',
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
