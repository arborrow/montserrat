<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\SearchRequest
 */
class SearchRequestTest extends TestCase
{
    /** @var \App\Http\Requests\SearchRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\SearchRequest();
    }

    /**
     * @test
     */
    public function authorize(): void
    {
        $actual = $this->subject->authorize();

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function rules(): void
    {
        $actual = $this->subject->rules();

        $this->assertEquals([
            'prefix_id' => 'integer|nullable',
            'first_name' => 'string|nullable',
            'middle_name' => 'string|nullable',
            'last_name' => 'string|nullable',
            'suffix_id' => 'integer|nullable',
            'nick_name' => 'string|nullable',
            'display_name' => 'string|nullable',
            'sort_name' => 'string|nullable',
            'contact_type' => 'integer|nullable',
            'subcontact_type' => 'integer|nullable',
            'has_avatar' => 'integer|nullable',
            'has_attachment' => 'integer|nullable',
            'attachment_description' => 'string|nullable',
            'phone' => 'string|nullable',
            'do_not_phone' => 'boolean|nullable',
            'do_not_sms' => 'boolean|nullable',
            'email' => 'string|nullable',
            'do_not_email' => 'boolean|nullable',
            'street_address' => 'string|nullable',
            'city' => 'string|nullable',
            'state_province_id' => 'integer|nullable',
            'postal_code' => 'string|nullable',
            'country_id' => 'integer|nullable',
            'do_not_mail' => 'boolean|nullable',
            'url' => 'string|nullable',
            'emergency_contact_name' => 'string|nullable',
            'emergency_contact_relationship' => 'string|nullable',
            'emergency_contact_phone' => 'string|nullable',
            'gender_id' => 'integer|nullable',
            'birth_date' => 'date|nullable',
            'religion_id' => 'integer|nullable',
            'occupation_id' => 'integer|nullable',
            'parish_id' => 'integer|nullable',
            'ethnicity_id' => 'integer|nullable',
            'languages' => 'array|nullable',
            'preferred_language_id' => 'integer|nullable',
            'referrals' => 'array|nullable',
            'deceased_date' => 'date|nullable',
            'is_deceased' => 'boolean|nullable',
            'note_health' => 'string|nullable',
            'note_dietary' => 'string|nullable',
            'note_general' => 'string|nullable',
            'note_room_preference' => 'string|nullable',
            'touchpoint_notes' => 'string|nullable',
            'touched_at' => 'date|nullable',
            'groups' => 'array|nullable',
        ], $actual);
    }

    /**
     * @test
     */
    public function messages(): void
    {
        $actual = $this->subject->messages();

        $this->assertEquals([], $actual);
    }

    // test cases...
}
