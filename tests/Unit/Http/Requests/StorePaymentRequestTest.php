<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\StorePaymentRequest
 */
class StorePaymentRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StorePaymentRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StorePaymentRequest();
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
            'donation_id' => 'required|integer|min:0',
            'payment_date' => 'required|date',
            'payment_amount' => 'required|numeric',
            'payment_idnumber' => 'nullable|numeric|min:0',
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
