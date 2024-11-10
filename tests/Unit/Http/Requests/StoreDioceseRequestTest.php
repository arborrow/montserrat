<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreDioceseRequest
 */
final class StoreDioceseRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreDioceseRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreDioceseRequest;
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

        // if Twilio is enabled then validate phone numbers otherwise allow strings
        if (config('settings.twilio_sid') !== null && config('settings.twilio_token') !== null) {
            $this->assertEquals([
                'organization_name' => 'required',
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
                'diocese_note' => 'string|nullable',
            ], $actual);
        } else {
            $this->assertEquals([
                'organization_name' => 'required',
                'bishop_id' => 'integer|min:0',
                'email_main' => 'email|nullable',
                'url_main' => 'url|nullable',
                'url_facebook' => 'url|regex:/facebook\\.com\\/.+/i|nullable',
                'url_google' => 'url|regex:/plus\\.google\\.com\\/.+/i|nullable',
                'url_twitter' => 'url|regex:/twitter\\.com\\/.+/i|nullable',
                'url_instagram' => 'url|regex:/instagram\\.com\\/.+/i|nullable',
                'url_linkedin' => 'url|regex:/linkedin\\.com\\/.+/i|nullable',
                'phone_main_phone' => 'string|nullable',
                'phone_main_fax' => 'string|nullable',
                'diocese_note' => 'string|nullable',
            ], $actual);
        }
    }

    #[Test]
    public function messages(): void
    {
        $actual = $this->subject->messages();

        $this->assertEquals([], $actual);
    }

    // test cases...
}
