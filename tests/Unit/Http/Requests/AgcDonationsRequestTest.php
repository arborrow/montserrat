<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\SearchRequest
 */
class AgcDonationsRequestTest extends TestCase
{
    /** @var \App\Http\Requests\AgcDonationsRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\AgcDonationsRequest();
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
        $valid_agc_donation_type = \App\Models\DonationType::active()
             ->whereIn('name', config('polanco.agc_donation_descriptions'))
             ->get();
        $valid_agc_donation_type_ids = $valid_agc_donation_type->modelKeys();

        $this->assertEquals([
            'donation_type_id' => 'in:'.implode(',', $valid_agc_donation_type_ids).',0|integer|nullable',
            'fiscal_year' => 'integer|nullable',
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
