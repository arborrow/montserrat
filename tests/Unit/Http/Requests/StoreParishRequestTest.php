<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreParishRequest
 */
class StoreParishRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreParishRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreParishRequest();
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
          'organization_name' => 'required',
          'diocese_id' => 'integer|min:0',
          'pastor_id' => 'integer|min:0',
          'parish_email_main' => 'email|nullable',
          'url_main' => 'url|nullable',
          'url_facebook' => 'url|regex:/facebook\\.com\\/.+/i|nullable',
          'url_google' => 'url|regex:/plus\\.google\\.com\\/.+/i|nullable',
          'url_twitter' => 'url|regex:/twitter\\.com\\/.+/i|nullable',
          'url_instagram' => 'url|regex:/instagram\\.com\\/.+/i|nullable',
          'url_linkedin' => 'url|regex:/linkedin\\.com\\/.+/i|nullable',
          'phone_main_phone' => 'phone|nullable',
          'phone_main_fax' => 'phone|nullable',
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
