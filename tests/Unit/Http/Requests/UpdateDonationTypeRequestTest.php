<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\Rule;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateDonationRequest
 */
class UpdateDonationTypeRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateDonationTypeRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateDonationTypeRequest();
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
            'id' => 'integer|min:1|required',
            'label' => 'string|max:125|required',
            'value' => 'string|max:125|nullable',
            'name' => 'string|max:125|nullable',
            'description' => 'string|nullable',
            'is_active' => 'boolean|nullable',
            'is_default' => 'boolean|nullable',
            'is_reserved' => 'boolean|nullable',
            'remember_token' => 'string|nullable',
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
