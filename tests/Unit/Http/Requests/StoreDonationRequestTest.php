<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreDonationRequest
 */
class StoreDonationRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreDonationRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreDonationRequest();
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
          'donor_id' => 'required|integer|min:0',
          'event_id' => 'integer|min:0',
          'donation_date' => 'required|date',
          'payment_date' => 'required|date',
          'donation_amount' => 'required|numeric',
          'payment_amount' => 'required|numeric',
          'payment_idnumber' => 'nullable|numeric|min:0',
          'start_date' => 'date|nullable|before:end_date',
          'end_date' => 'date|nullable|after:start_date',
          'donation_install' => 'numeric|min:0|nullable',
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
