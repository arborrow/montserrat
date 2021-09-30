<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdatePersonRequest
 */
class UpdatePersonRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdatePersonRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdatePersonRequest();
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
            'address_home_address1' => 'string|max:125|nullable',
            'address_home_address2' => 'string|max:125|nullable',
            'address_home_city' => 'string|max:125|nullable',
            'address_home_state' => 'integer|min:0|nullable',
            'address_home_zip' => 'alpha_dash|max:12|nullable',
            'address_home_country' => 'integer|min:0|nullable',
            'address_other_address1' => 'string|max:125|nullable',
            'address_other_address2' => 'string|max:125|nullable',
            'address_other_city' => 'string|max:125|nullable',
            'address_other_state' => 'integer|min:0|nullable',
            'address_other_zip' => 'alpha_dash|max:12|nullable',
            'address_other_country' => 'integer|min:0|nullable',
            'address_work_address1' => 'string|max:125|nullable',
            'address_work_address2' => 'string|max:125|nullable',
            'address_work_city' => 'string|max:125|nullable',
            'address_work_state' => 'integer|min:0|nullable',
            'address_work_zip' => 'alpha_dash|max:12|nullable',
            'address_work_country' => 'integer|min:0|nullable',
            'agc_household_name' => 'string|max:200|nullable',
            'attachment' => 'file|mimes:pdf,doc,docx,zip|max:10000|nullable',
            'attachment_description' => 'string|max:200|nullable',
            'avatar' => 'image|max:5000|nullable',
            'birth_date' => 'date|nullable',
            'contact_type' => 'integer|min:0|nullable',
            'deceased_date' => 'date|nullable',
            'display_name' => 'string|max:200|nullable',
            'do_not_email' => 'boolean|nullable',
            'do_not_mail' => 'boolean|nullable',
            'do_not_phone' => 'boolean|nullable',
            'do_not_sms' => 'boolean|nullable',
            'email_home' => 'email|nullable',
            'email_other' => 'email|nullable',
            'email_work' => 'email|nullable',
            'emergency_contact_name' => 'string|max:100|nullable',
            'emergency_contact_phone' => 'phone|nullable',
            'emergency_contact_phone_alternate' => 'phone|nullable',
            'emergency_contact_relationship' => 'string|max:100|nullable',
            'ethnicity_id' => 'integer|min:0|nullable',
            'first_name' => 'required|string|max:75',
            'gender_id' => 'integer|min:0|nullable',
            'is_assistant' => 'boolean|nullable',
            'is_bishop' => 'boolean|nullable',
            'is_board' => 'boolean|nullable',
            'is_ambassador' => 'boolean|nullable',
            'is_deacon' => 'boolean|nullable',
            'is_deceased' => 'boolean|nullable',
            'is_donor' => 'boolean|nullable',
            'is_director' => 'boolean|nullable',
            'is_hlm2017' => 'boolean|nullable',
            'is_innkeeper' => 'boolean|nullable',
            'is_jesuit' => 'boolean|nullable',
            'is_pastor' => 'boolean|nullable',
            'is_priest' => 'boolean|nullable',
            'is_provincial' => 'boolean|nullable',
            'is_retreatant' => 'boolean|nullable',
            'is_staff' => 'boolean|nullable',
            'is_steward' => 'boolean|nullable',
            'is_superior' => 'boolean|nullable',
            'is_volunteer' => 'boolean|nullable',
            'last_name' => 'required|string|max:75',
            'middle_name' => 'string|nullable|max:75',
            'nick_name' => 'string|nullable|max:250',
            'note_contact' => 'string|nullable|max:250',
            'note_dietary' => 'string|nullable|max:250',
            'note_health' => 'string|nullable|max:250',
            'note_room_preference' => 'string|nullable|max:250',
            'occupation_id' => 'integer|min:0|nullable',
            'parish_id' => 'integer|min:0|nullable',
            'phone_home_phone' => 'phone|nullable',
            'phone_home_mobile' => 'phone|nullable',
            'phone_home_fax' => 'phone|nullable',
            'phone_work_phone' => 'phone|nullable',
            'phone_work_mobile' => 'phone|nullable',
            'phone_work_fax' => 'phone|nullable',
            'phone_other_phone' => 'phone|nullable',
            'phone_other_mobile' => 'phone|nullable',
            'phone_other_fax' => 'phone|nullable',
            'prefix_id' => 'integer|min:0|nullable',
            'preferred_language_id' => 'integer|min:0|nullable',
            'primary_address_location_id' => 'integer|min:0|nullable',
            'primary_email_location_id' => 'integer|min:0|nullable',
            'primary_phone_location_id' => 'string|nullable',
            'religion_id' => 'integer|min:0|nullable',
            'sort_name' => 'string|max:200|nullable',
            'subcontact_type' => 'integer|min:0|nullable',
            'suffix_id' => 'integer|min:0|nullable',
            'url_main' => 'url|nullable',
            'url_work' => 'url|nullable',
            'url_facebook' => 'url|regex:/facebook\\.com\\/.+/i|nullable',
            'url_google' => 'url|regex:/plus\\.google\\.com\\/.+/i|nullable',
            'url_twitter' => 'url|regex:/twitter\\.com\\/.+/i|nullable',
            'url_instagram' => 'url|regex:/instagram\\.com\\/.+/i|nullable',
            'url_linkedin' => 'url|regex:/linkedin\\.com\\/.+/i|nullable',
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
