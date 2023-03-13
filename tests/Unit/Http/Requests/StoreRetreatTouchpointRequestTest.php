<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreRetreatTouchpointRequest
 */
class StoreRetreatTouchpointRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreRetreatTouchpointRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreRetreatTouchpointRequest();
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
            'event_id' => 'required|integer|min:0',
            'touched_at' => 'required|date',
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
