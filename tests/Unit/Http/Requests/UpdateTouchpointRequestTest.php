<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateTouchpointRequest
 */
class UpdateTouchpointRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateTouchpointRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateTouchpointRequest();
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
            'touched_at' => 'required|date',
            'person_id' => 'required|integer|min:0',
            'staff_id' => 'required|integer|min:0',
            'type' => 'in:Email,Call,Letter,Face,Other',
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
