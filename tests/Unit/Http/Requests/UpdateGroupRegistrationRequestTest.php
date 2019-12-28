<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateGroupRegistrationRequest
 */
class UpdateGroupRegistrationRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateGroupRegistrationRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateGroupRegistrationRequest();
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
          'register_date' => 'required|date',
          'attendance_confirm_date' => 'date|nullable',
          'registration_confirm_date' => 'date|nullable',
          'canceled_at' => 'date|nullable',
          'arrived_at' => 'date|nullable',
          'departed_at' => 'date|nullable',
          'contact_id' => 'required|integer|min:0',
          'event_id' => 'required|integer|min:0',
          'status_id' => 'required|integer|min:0',
          'room_id' => 'required|integer|min:0',
          'deposit' => 'required|numeric|min:0|max:10000',
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
