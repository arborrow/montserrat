<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreRetreatWaitlistTouchpointRequest
 */
final class StoreRetreatWaitlistTouchpointRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreRetreatWaitlistTouchpointRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreRetreatWaitlistTouchpointRequest;
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
            'event_id' => 'required|integer|min:0',
            'touched_at' => 'required|date',
            'staff_id' => 'required|integer|min:0',
            'type' => 'in:Email,Call,Letter,Face,Other',
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
