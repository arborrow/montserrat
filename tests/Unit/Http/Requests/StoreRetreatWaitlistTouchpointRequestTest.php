<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreRetreatWaitlistTouchpointRequest
 */
class StoreRetreatWaitlistTouchpointRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreRetreatWaitlistTouchpointRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreRetreatWaitlistTouchpointRequest();
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
          'event_id' => 'required|integer|min:0',
          'touched_at' => 'required|date',
          'staff_id' => 'required|integer|min:0',
          'type' => 'in:Email,Call,Letter,Face,Other',
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
