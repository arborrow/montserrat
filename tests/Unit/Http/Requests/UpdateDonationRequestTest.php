<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Validation\Rule;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateDonationRequest
 */
class UpdateDonationRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateDonationRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateDonationRequest();
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
            'donation_amount' => 'required|numeric',
            'start_date' => 'date|nullable|before:end_date',
            'end_date' => 'date|nullable|after:start_date',
            'donation_install' => 'numeric|min:0|nullable',
            'donation_thank_you' => Rule::in(['Y', 'N']),
            'stripe_invoice' => 'string|nullable',
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
