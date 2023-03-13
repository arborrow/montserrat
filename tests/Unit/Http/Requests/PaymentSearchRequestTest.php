<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\SearchRequest
 */
class PaymentSearchRequestTest extends TestCase
{
    /** @var \App\Http\Requests\PaymentSearchRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\PaymentSearchRequest();
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
            'payment_date_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'payment_amount_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'payment_date' => 'date|nullable',
            'payment_amount' => 'numeric|nullable',
            'payment_description' => 'string|nullable',
            'cknumber' => 'numeric|nullable',
            'ccnumber' => 'numeric|nullable',
            'note' => 'string|nullable',
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
