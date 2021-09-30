<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateAddressRequest
 */
class UpdateAddressRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateAddressRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateAddressRequest();
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
    {   // TODO: languages and referrals

        $actual = $this->subject->rules();

        $this->assertEquals([
            'city' => 'string|max:125|nullable',
            'contact_id' => 'required|integer|min:0',
            'country_id' => 'integer|min:0|nullable',
            'is_primary' => 'boolean|nullable',
            'location_type_id' => 'required|integer|min:0',
            'postal_code' => 'alpha_dash|max:12|nullable',
            'state_province_id' => 'integer|min:0|nullable',
            'street_address' => 'string|max:125|nullable',
            'supplemental_address_1' => 'string|max:125|nullable',
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
