<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreVendorRequest
 */
class StoreVendorRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreVendorRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreVendorRequest();
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

        // if Twilio is enabled then validate phone numbers otherwise allow strings
         if (null !== config('settings.twilio_sid') && null !== config('settings.twilio_token')) {

            $this->assertEquals([
              'organization_name' => 'required',
              'vendor_email_main' => 'email|nullable',
              'url_main' => 'url|nullable',
              'url_facebook' => 'url|regex:/facebook\\.com\\/.+/i|nullable',
              'url_google' => 'url|regex:/plus\\.google\\.com\\/.+/i|nullable',
              'url_twitter' => 'url|regex:/twitter\\.com\\/.+/i|nullable',
              'url_instagram' => 'url|regex:/instagram\\.com\\/.+/i|nullable',
              'url_linkedin' => 'url|regex:/linkedin\\.com\\/.+/i|nullable',
              'phone_main_phone' => 'phone|nullable',
              'phone_main_fax' => 'phone|nullable',
            ], $actual);
        } else {
          $this->assertEquals([
            'organization_name' => 'required',
            'vendor_email_main' => 'email|nullable',
            'url_main' => 'url|nullable',
            'url_facebook' => 'url|regex:/facebook\\.com\\/.+/i|nullable',
            'url_google' => 'url|regex:/plus\\.google\\.com\\/.+/i|nullable',
            'url_twitter' => 'url|regex:/twitter\\.com\\/.+/i|nullable',
            'url_instagram' => 'url|regex:/instagram\\.com\\/.+/i|nullable',
            'url_linkedin' => 'url|regex:/linkedin\\.com\\/.+/i|nullable',
            'phone_main_phone' => 'string|nullable',
            'phone_main_fax' => 'string|nullable',
          ], $actual);
        }
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
