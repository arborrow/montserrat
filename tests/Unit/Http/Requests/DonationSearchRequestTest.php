<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\Rule;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\SearchRequest
 */
class DonationSearchRequestTest extends TestCase
{
    /** @var \App\Http\Requests\DonationSearchRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\DonationSearchRequest();
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
            'donation_date_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'donation_amount_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'start_date_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'end_date_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'donation_install_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'donation_date' => 'date|nullable',
            'start_date' => 'date|nullable',
            'end_date' => 'date|nullable',
            'donation_description' => 'string|nullable',
            'event_id' => 'integer|nullable',
            'donation_amount' => 'numeric|nullable',
            'donation_install' => 'numeric|nullable',
            'notes' => 'string|nullable',
            'terms' => 'string|nullable',
            'donation_thank_you' => 'string|nullable',
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
