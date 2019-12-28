<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdatePaymentRequest
 */
class UpdatePaymentRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdatePaymentRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdatePaymentRequest();
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
          'donation_id' => 'required|integer|min:0',
          'payment_date' => 'required|date',
          'payment_amount' => 'required|numeric',
          'payment_idnumber' => 'nullable|numeric|min:0',
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
