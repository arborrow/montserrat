<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateDioceseRequest
 */
class UpdateDioceseRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateDioceseRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateDioceseRequest();
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
          'display_name' => 'required',
          'sort_name' => 'required',
          'bishop_id' => 'integer|min:0',
          'email_main' => 'email|nullable',
          'url_main' => 'url|nullable',
          'url_facebook' => 'url|regex:/facebook\\.com\\/.+/i|nullable',
          'url_google' => 'url|regex:/plus\\.google\\.com\\/.+/i|nullable',
          'url_twitter' => 'url|regex:/twitter\\.com\\/.+/i|nullable',
          'url_instagram' => 'url|regex:/instagram\\.com\\/.+/i|nullable',
          'url_linkedin' => 'url|regex:/linkedin\\.com\\/.+/i|nullable',
          'phone_main_phone' => 'phone|nullable',
          'phone_main_fax' => 'phone|nullable',
          'avatar' => 'image|max:5000|nullable',
          'attachment' => 'file|mimes:pdf,doc,docx,zip|max:10000|nullable',
          'attachment_description' => 'string|max:200|nullable',
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
