<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\Rule;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateDonationRequest
 */
class UpdateWebsiteRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateWebsiteRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateWebsiteRequest();
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
            'website_type' => 'string|in:'.implode(',', config('polanco.website_types')).'|required',
            'url' => 'string|max:250|nullable',
            'description' => 'string|nullable',
            'asset_id' => 'integer|min:1|nullable',
            'contact_id' => 'integer|min:1|nullable',
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
