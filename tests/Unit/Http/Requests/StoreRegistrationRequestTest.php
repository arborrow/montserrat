<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreRegistrationRequest
 */
final class StoreRegistrationRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreRegistrationRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreRegistrationRequest;
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
            'event_id' => 'required|integer|min:1',
            'status_id' => 'required|integer|min:1',
            'contact_id' => 'required|integer|min:1',
            'deposit' => 'required|numeric|min:0|max:10000',
            'num_registrants' => 'integer|min:0|max:99|nullable',
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
