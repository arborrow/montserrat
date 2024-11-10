<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateRegistrationRequest
 */
final class UpdateRegistrationRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateRegistrationRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateRegistrationRequest;
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
            'register_date' => 'required|date',
            'attendance_confirm_date' => 'date|nullable',
            'registration_confirm_date' => 'date|nullable',
            'canceled_at' => 'date|nullable',
            'arrived_at' => 'date|nullable',
            'departed_at' => 'date|nullable',
            'event_id' => 'required|integer|min:0',
            'status_id' => 'required|integer|min:1',
            'room_id' => 'required|integer|min:0',
            'deposit' => 'required|numeric|min:0|max:10000',
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
