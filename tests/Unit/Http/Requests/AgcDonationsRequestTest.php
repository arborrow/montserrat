<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\SearchRequest
 */
final class AgcDonationsRequestTest extends TestCase
{
    /** @var \App\Http\Requests\AgcDonationsRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\AgcDonationsRequest;
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
        $valid_agc_donation_type = \App\Models\DonationType::active()
            ->whereIn('name', config('polanco.agc_donation_descriptions'))
            ->get();
        $valid_agc_donation_type_ids = $valid_agc_donation_type->modelKeys();

        $this->assertEquals([
            'donation_type_id' => 'in:'.implode(',', $valid_agc_donation_type_ids).',0|integer|nullable',
            'fiscal_year' => 'integer|nullable',
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
