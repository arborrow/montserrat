<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StorePersonRequest
 */
class StorePersonRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StorePersonRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StorePersonRequest();
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
          'first_name' => 'required',
          'last_name' => 'required',
          'email_home' => 'email|nullable',
          'email_work' => 'email|nullable',
          'email_other' => 'email|nullable',
          'birth_date' => 'date|nullable',
          'deceased_date' => 'date|nullable',
          'url_main' => 'url|nullable',
          'url_work' => 'url|nullable',
          'url_facebook' => 'url|regex:/facebook\\.com\\/.+/i|nullable',
          'url_google' => 'url|regex:/plus\\.google\\.com\\/.+/i|nullable',
          'url_twitter' => 'url|regex:/twitter\\.com\\/.+/i|nullable',
          'url_instagram' => 'url|regex:/instagram\\.com\\/.+/i|nullable',
          'url_linkedin' => 'url|regex:/linkedin\\.com\\/.+/i|nullable',
          'parish_id' => 'integer|min:0|nullable',
          'gender_id' => 'integer|min:0|nullable',
          'ethnicity_id' => 'integer|min:0|nullable',
          'religion_id' => 'integer|min:0|nullable',
          'contact_type' => 'integer|min:0|nullable',
          'subcontact_type' => 'integer|min:0|nullable',
          'occupation_id' => 'integer|min:0|nullable',
          'avatar' => 'image|max:5000|nullable',
          'emergency_contact_phone' => 'phone|nullable',
          'emergency_contact_phone_alternate' => 'phone|nullable',
          'phone_home_phone' => 'phone|nullable',
          'phone_home_mobile' => 'phone|nullable',
          'phone_home_fax' => 'phone|nullable',
          'phone_work_phone' => 'phone|nullable',
          'phone_work_mobile' => 'phone|nullable',
          'phone_work_fax' => 'phone|nullable',
          'phone_other_phone' => 'phone|nullable',
          'phone_other_mobile' => 'phone|nullable',
          'phone_other_fax' => 'phone|nullable',
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
