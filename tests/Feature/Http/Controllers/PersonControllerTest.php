<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ContactLanguage;
use App\Models\EmergencyContact;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PersonController
 */
class PersonControllerTest extends TestCase
{
    use withFaker;

    /**
     * @test
     */
    public function assistants_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('assistants'));

        $response->assertOk();
        $response->assertViewIs('persons.role');
        $response->assertViewHas('persons');
        $response->assertViewHas('role');
        $response->assertSeeText('Assistant');
    }

    /**
     * @test
     */
    public function bishops_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('bishops'));

        $response->assertOk();
        $response->assertViewIs('persons.role');
        $response->assertViewHas('persons');
        $response->assertViewHas('role');
        $response->assertSeeText('Bishop');
    }

    /**
     * @test
     */
    public function boardmembers_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('boardmembers'));

        $response->assertOk();
        $response->assertViewIs('persons.role');
        $response->assertViewHas('persons');
        $response->assertViewHas('role');
        $response->assertSeeText('Board member');
    }

    /**
     * @test
     */
    public function ambassadors_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('ambassadors'));

        $response->assertOk();
        $response->assertViewIs('persons.role');
        $response->assertViewHas('persons');
        $response->assertViewHas('role');
        $response->assertSeeText('Ambassador');
    }

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-contact');

        $response = $this->actingAs($user)->get(route('person.create'));

        $response->assertOk();
        $response->assertViewIs('persons.create');
        $response->assertViewHas('parish_list');
        $response->assertViewHas('ethnicities');
        $response->assertViewHas('states');
        $response->assertViewHas('countries');
        $response->assertViewHas('suffixes');
        $response->assertViewHas('prefixes');
        $response->assertViewHas('languages');
        $response->assertViewHas('genders');
        $response->assertViewHas('religions');
        $response->assertViewHas('occupations');
        $response->assertViewHas('contact_types');
        $response->assertViewHas('subcontact_types');
        $response->assertViewHas('referrals');
        $response->assertSeeText('Create Person');
    }

    /**
     * @test
     */
    public function deacons_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('deacons'));

        $response->assertOk();
        $response->assertViewIs('persons.role');
        $response->assertViewHas('persons');
        $response->assertViewHas('role');
        $response->assertSeeText('Deacon');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-contact');
        $person = \App\Models\Contact::factory()->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => null,
        ]);

        $response = $this->actingAs($user)->delete(route('person.destroy', ['person' => $person]));
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('PersonController@index'));
        $this->assertSoftDeleted($person);
    }

    /**
     * @test
     */
    public function directors_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('directors'));

        $response->assertOk();
        $response->assertViewIs('persons.role');
        $response->assertViewHas('persons');
        $response->assertViewHas('role');
        $response->assertSeeText('Director');
    }

    /**
     * @test
     */
    public function duplicates_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-contact');

        $response = $this->actingAs($user)->get(route('duplicates'));

        $response->assertOk();
        $response->assertViewIs('persons.duplicates');
        $response->assertViewHas('duplicates');
        $response->assertSeeText('List of duplicated');
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-contact');

        $person = \App\Models\Contact::factory()->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => null,
        ]);
        $parish = \App\Models\Contact::factory()->create([
            'contact_type' => config('polanco.contact_type.organization'),
            'subcontact_type' => config('polanco.contact_type.parish'),
        ]);
        $parishioner = \App\Models\Relationship::factory()->create([
            'contact_id_a' => $parish->id,
            'contact_id_b' => $person->id,
            'relationship_type_id' => config('polanco.relationship_type.parishioner'),
            'is_active' => 1,
        ]);

        $languages = \App\Models\Language::whereIsActive(1)->get()->random(2);
        foreach ($languages as $language) {
            $contact_language = new \App\Models\ContactLanguage;
            $contact_language->contact_id = $person->id;
            $contact_language->language_id = $language->id;
            $contact_language->save();
        }
        $referrals = \App\Models\Referral::whereIsActive(1)->get()->random(2);
        foreach ($referrals as $referral) {
            $contact_referral = new \App\Models\ContactReferral;
            $contact_referral->contact_id = $person->id;
            $contact_referral->referral_id = $referral->id;
            $contact_referral->save();
        }

        $emergency_contact = \App\Models\EmergencyContact::factory()->create([
            'contact_id' => $person->id,
        ]);

        // create addresses
        $home_address = \App\Models\Address::factory()->create([
            'contact_id' => $person->id,
            'location_type_id' => config('polanco.location_type.home'),
        ]);
        $work_address = \App\Models\Address::factory()->create([
            'contact_id' => $person->id,
            'location_type_id' => config('polanco.location_type.work'),
        ]);
        $other_address = \App\Models\Address::factory()->create([
            'contact_id' => $person->id,
            'location_type_id' => config('polanco.location_type.other'),
        ]);
        // create phones
        // TODO: improve phone factory to generate some phone numbers (be mindful of possible Twilio checks and failures for fake numbers - consider hard coding some fake numbers)
        $home_phone = \App\Models\Phone::factory()->create([
            'contact_id' => $person->id,
            'location_type_id' => config('polanco.location_type.home'),
            'phone_type' => 'Phone',
        ]);
        $home_mobile = \App\Models\Phone::factory()->create([
            'contact_id' => $person->id,
            'location_type_id' => config('polanco.location_type.home'),
            'phone_type' => 'Mobile',
        ]);
        $home_fax = \App\Models\Phone::factory()->create([
            'contact_id' => $person->id,
            'location_type_id' => config('polanco.location_type.home'),
            'phone_type' => 'fax',
        ]);
        $work_phone = \App\Models\Phone::factory()->create([
            'contact_id' => $person->id,
            'location_type_id' => config('polanco.location_type.work'),
            'phone_type' => 'Phone',
        ]);
        $work_mobile = \App\Models\Phone::factory()->create([
            'contact_id' => $person->id,
            'location_type_id' => config('polanco.location_type.work'),
            'phone_type' => 'Mobile',
        ]);
        $work_fax = \App\Models\Phone::factory()->create([
            'contact_id' => $person->id,
            'location_type_id' => config('polanco.location_type.work'),
            'phone_type' => 'fax',
        ]);
        $other_phone = \App\Models\Phone::factory()->create([
            'contact_id' => $person->id,
            'location_type_id' => config('polanco.location_type.other'),
            'phone_type' => 'Phone',
        ]);
        $other_mobile = \App\Models\Phone::factory()->create([
            'contact_id' => $person->id,
            'location_type_id' => config('polanco.location_type.other'),
            'phone_type' => 'Mobile',
        ]);
        $other_fax = \App\Models\Phone::factory()->create([
            'contact_id' => $person->id,
            'location_type_id' => config('polanco.location_type.other'),
            'phone_type' => 'fax',
        ]);

        $home_email = \App\Models\Email::factory()->create([
            'contact_id' => $person->id,
            'location_type_id' => config('polanco.location_type.home'),
        ]);
        $work_email = \App\Models\Email::factory()->create([
            'contact_id' => $person->id,
            'location_type_id' => config('polanco.location_type.work'),
        ]);
        $other_email = \App\Models\Email::factory()->create([
            'contact_id' => $person->id,
            'location_type_id' => config('polanco.location_type.other'),
        ]);
        $url_main = \App\Models\Website::factory()->create([
            'contact_id' => $person->id,
            'website_type' => 'Main',
            'url' => $this->faker->url,
        ]);
        $url_work = \App\Models\Website::factory()->create([
            'contact_id' => $person->id,
            'website_type' => 'Work',
            'url' => $this->faker->url,
        ]);
        $url_facebook = \App\Models\Website::factory()->create([
            'contact_id' => $person->id,
            'website_type' => 'Facebook',
            'url' => 'https://facebook.com/'.$this->faker->slug,
        ]);
        $url_instagram = \App\Models\Website::factory()->create([
            'contact_id' => $person->id,
            'website_type' => 'Instagram',
            'url' => 'https://instagram.com/'.$this->faker->slug,
        ]);
        $url_linkedin = \App\Models\Website::factory()->create([
            'contact_id' => $person->id,
            'website_type' => 'LinkedIn',
            'url' => 'https://linkedin.com/'.$this->faker->slug,
        ]);
        $url_twitter = \App\Models\Website::factory()->create([
            'contact_id' => $person->id,
            'website_type' => 'Twitter',
            'url' => 'https://twitter.com/'.$this->faker->slug,
        ]);
        $note_health = \App\Models\Note::factory()->create([
            'entity_table' => 'contact',
            'entity_id' => $person->id,
            'subject' => 'Health Note',
        ]);
        $note_dietary = \App\Models\Note::factory()->create([
            'entity_table' => 'contact',
            'entity_id' => $person->id,
            'subject' => 'Dietary Note',
       ]);
        $note_contact = \App\Models\Note::factory()->create([
            'entity_table' => 'contact',
            'entity_id' => $person->id,
            'subject' => 'Contact Note',
        ]);
        $note_room_preference = \App\Models\Note::factory()->create([
            'entity_table' => 'contact',
            'entity_id' => $person->id,
            'subject' => 'Room Preference',
        ]);

        $response = $this->actingAs($user)->get(route('person.edit', ['person' => $person]));

        $response->assertOk();
        $response->assertViewIs('persons.edit');
        $response->assertViewHas('prefixes');
        $response->assertViewHas('suffixes');
        $response->assertViewHas('person');
        $response->assertViewHas('parish_list');
        $response->assertViewHas('ethnicities');
        $response->assertViewHas('states');
        $response->assertViewHas('countries');
        $response->assertViewHas('genders');
        $response->assertViewHas('languages');
        $response->assertViewHas('defaults');
        $response->assertViewHas('religions');
        $response->assertViewHas('occupations');
        $response->assertViewHas('contact_types');
        $response->assertViewHas('subcontact_types');
        $response->assertViewHas('referrals');
        $response->assertSeeText('Edit');
        $response->assertSee($person->display_name);
        // names
        $this->assertTrue($this->findFieldValueInResponseContent('prefix_id', $person->prefix_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('first_name', $person->first_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('middle_name', $person->middle_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('last_name', $person->last_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('suffix_id', $person->suffix_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('nick_name', $person->nick_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('display_name', $person->display_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('sort_name', $person->sort_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('agc_household_name', $person->agc_household_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('contact_type', $person->contact_type, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('subcontact_type', $person->subcontact_type, 'select', $response->getContent()));
        // emergency contact info
        $this->assertTrue($this->findFieldValueInResponseContent('emergency_contact_name', $person->emergency_contact_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('emergency_contact_relationship', $person->emergency_contact_relationship, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('emergency_contact_phone', $person->emergency_contact_phone, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('emergency_contact_phone_alternate', $person->emergency_contact_phone_alternate, 'text', $response->getContent()));
        // notes
        $this->assertTrue($this->findFieldValueInResponseContent('note_health', $person->note_health_text, 'textarea', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('note_dietary', $person->note_dietary_text, 'textarea', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('note_contact', $person->note_contact_text, 'textarea', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('note_room_preference', $person->note_room_preference_text, 'textarea', $response->getContent()));
        // demographics
        $this->assertTrue($this->findFieldValueInResponseContent('gender_id', $person->gender_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('birth_date', $person->birth_date, 'date', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('religion_id', $person->religion_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('occupation_id', $person->occupation_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('parish_id', $person->parish_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('ethnicity_id', $person->ethnicity_id, 'select', $response->getContent()));

        $this->assertTrue($this->findFieldValueInResponseContent('languages[]', $person->languages->pluck('id'), 'multiselect', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('referrals[]', $person->referrals->pluck('id'), 'multiselect', $response->getContent()));

        $this->assertTrue($this->findFieldValueInResponseContent('preferred_communication_method_id', $person->preferred_communication_method, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('preferred_language_id', $person->preferred_language_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_deceased', $person->is_deceased, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('deceased_date', $person->deceased_date, 'date', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('gender_id', $person->gender_id, 'select', $response->getContent()));

        // groups and relationships
        $this->assertTrue($this->findFieldValueInResponseContent('is_donor', $person->is_donor, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_steward', $person->is_steward, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_volunteer', $person->is_volunteer, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_retreatant', $person->is_retreatant, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_ambassador', $person->is_ambassador, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_bishop', $person->is_bishop, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_priest', $person->is_priest, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_deacon', $person->is_deacon, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_pastor', $person->is_pastor, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_jesuit', $person->is_jesuit, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_provincial', $person->is_provincial, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_superior', $person->is_superior, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_board', $person->is_board, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_staff', $person->is_staff, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_director', $person->is_director, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_innkeeper', $person->is_innkeeper, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('is_assistant', $person->is_assistant, 'checkbox', $response->getContent()));
        // addresses
        $this->assertTrue($this->findFieldValueInResponseContent('do_not_mail', $person->do_not_mail, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_home_address1', $home_address->street_address, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_home_address2', $home_address->supplemental_address_1, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_home_city', $home_address->city, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_home_state', $home_address->state_province_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_home_zip', $home_address->postal_code, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_home_country', $home_address->country_id, 'select', $response->getContent()));
        // work
        $this->assertTrue($this->findFieldValueInResponseContent('address_work_address1', $work_address->street_address, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_work_address2', $work_address->supplemental_address_1, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_work_city', $work_address->city, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_work_state', $work_address->state_province_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_work_zip', $work_address->postal_code, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_work_country', $work_address->country_id, 'select', $response->getContent()));
        // other
        $this->assertTrue($this->findFieldValueInResponseContent('address_other_address1', $other_address->street_address, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_other_address2', $other_address->supplemental_address_1, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_other_city', $other_address->city, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_other_state', $other_address->state_province_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_other_zip', $other_address->postal_code, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('address_other_country', $other_address->country_id, 'select', $response->getContent()));
        // phones
        $this->assertTrue($this->findFieldValueInResponseContent('do_not_phone', $person->do_not_phone, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('do_not_sms', $person->do_not_sms, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_home_phone', $home_phone->phone.$home_phone->phone_extension, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_home_mobile', $home_mobile->phone.$home_mobile->phone_extension, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_home_fax', $home_fax->phone.$home_fax->phone_extension, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_work_phone', $work_phone->phone.$work_phone->phone_extension, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_work_mobile', $work_mobile->phone.$work_mobile->phone_extension, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_work_fax', $work_fax->phone.$work_fax->phone_extension, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_other_phone', $other_phone->phone.$other_phone->phone_extension, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_other_mobile', $other_mobile->phone.$other_mobile->phone_extension, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_other_fax', $other_fax->phone.$other_fax->phone_extension, 'text', $response->getContent()));
        // emails
        $this->assertTrue($this->findFieldValueInResponseContent('do_not_email', $person->do_not_email, 'checkbox', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('email_home', $home_email->email, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('email_work', $work_email->email, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('email_other', $other_email->email, 'text', $response->getContent()));
        // urls
        $this->assertTrue($this->findFieldValueInResponseContent('url_main', $url_main->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_work', $url_work->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_facebook', $url_facebook->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_instagram', $url_instagram->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_linkedin', $url_linkedin->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_twitter', $url_twitter->url, 'text', $response->getContent()));
        // TODO: add some groups and relationships
    }

    /**
     * @test
     */
    public function envelope_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');
        $person = \App\Models\Contact::factory()->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => null,
        ]);

        $response = $this->actingAs($user)->get(route('envelope', ['id' => $person->id]));

        $response->assertViewIs('persons.envelope10');
        $response->assertSee($person->agc_household_name);
    }

    /**
     * @test
     */
    public function index_displays_paginated_contacts_contacts()
    {
        $person = \App\Models\Contact::factory()->create([
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => null,
        ]);

        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('person.index'));

        $response->assertOk();
        $response->assertViewIs('persons.index');
        $response->assertViewHas('persons');

        // TODO: verify that at least one contact is on the list
        // TODO: verify contact created with this test is returned as part of the persons.index results
        // n.b. - this could fail if there are more than the paginated number of contacts with the created contact on another page
        $persons = $response->viewData('persons');
        $count_persons = $persons->count();
        $this->assertGreaterThanOrEqual('1', $count_persons);
    }

    /**
     * @test
     */
    public function index_returns_403_without_proper_permission()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('person.index'));

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function innkeepers_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('innkeepers'));

        $response->assertOk();
        $response->assertViewIs('persons.role');
        $response->assertViewHas('persons');
        $response->assertViewHas('role');
        $response->assertSeeText('Innkeeper');
    }

    /**
     * @test
     */
    public function jesuits_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('jesuits'));

        $response->assertOk();
        $response->assertViewIs('persons.role');
        $response->assertViewHas('persons');
        $response->assertViewHas('role');
        $response->assertSeeText('Jesuit');
    }

    /**
     * @test
     */
    public function lastnames_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');
        $person = \App\Models\Contact::factory()->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => null,
        ]);

        $response = $this->actingAs($user)->get(route('lastnames', [
            'letter' => strtolower(substr($person->last_name, 0, 1)),
        ]));
        $persons = $response->viewData('persons');

        $response->assertOk();
        $response->assertViewIs('persons.index');
        $response->assertViewHas('persons');
        $this->assertGreaterThanOrEqual('1', $persons->count());
    }

    /**
     * @test
     */
    public function merge_returns_an_ok_response()
    {
        $user = \App\Models\User::factory()->create();
        $user->assignRole('test-role:merge');

        $person = \App\Models\Contact::factory()->create([
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => null,
        ]);

        $duplicate_person = \App\Models\Contact::factory()->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => null,
          'sort_name' => $person->sort_name,
        ]);

        $response = $this->actingAs($user)->get(route('merge', ['contact_id' => $person->id]));

        /* $response = $this->actingAs($user)->get(route('merge'),[
            'contact_id' => $person->id,
            'merge_id' => null,
          ]);
*/

        $response->assertOk();
        $response->assertViewIs('persons.merge');
        $response->assertViewHas('contact');
        $response->assertViewHas('duplicates');

        // TODO: perform additional assertions and create additional tests to ensure that the merging functionality actually works
    }

    /**
     * @test
     */
    public function merge_staff_returns_fail_response()
    {
        $user = \App\Models\User::factory()->create();
        $user->assignRole('test-role:merge');

        $person = \App\Models\Contact::factory()->create([
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => null,
        ]);

        $duplicate_person = \App\Models\Contact::factory()->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => null,
          'sort_name' => $person->sort_name,
        ]);

        $touchpoint = \App\Models\Touchpoint::factory()->create([
            'staff_id' => $duplicate_person->id,
        ]);

        $response = $this->actingAs($user)->get(route('merge', ['contact_id' => $person->id, 'merge_id' => $duplicate_person->id]));
        $response->assertOk();
        $response->assertViewIs('persons.merge');
        $response->assertViewHas('contact');
        $response->assertViewHas('duplicates');
        $response->assertSeeText('Staff members with touchpoints or assigned jobs cannot be merged');
    }

    /**
     * @test
     */
    public function merge_destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-duplicate');
        $person = \App\Models\Contact::factory()->create([
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => null,
        ]);

        $duplicate_person = \App\Models\Contact::factory()->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => null,
          'sort_name' => $person->sort_name,
        ]);

        $response = $this->actingAs($user)->get(route('merge_delete', ['id' => $duplicate_person->id, 'return_id' => $person->id]));

        $response->assertRedirect(action('PersonController@merge', $person->id));
        $this->assertSoftDeleted($duplicate_person);
    }

    /**
     * @test
     */
    public function pastors_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('pastors'));

        $response->assertOk();
        $response->assertViewIs('persons.role');
        $response->assertViewHas('persons');
        $response->assertViewHas('role');
        $response->assertSeeText('Pastor');
    }

    /**
     * @test
     */
    public function priests_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('priests'));

        $response->assertOk();
        $response->assertViewIs('persons.role');
        $response->assertViewHas('persons');
        $response->assertViewHas('role');
        $response->assertSeeText('Priest');
    }

    /**
     * @test
     */
    public function provincials_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('provincials'));

        $response->assertOk();
        $response->assertViewIs('persons.role');
        $response->assertViewHas('persons');
        $response->assertViewHas('role');
        $response->assertSeeText('Provincial');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');
        $person = \App\Models\Contact::factory()->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => null,
        ]);
        // var_dump($person->id);
        $response = $this->actingAs($user)->get(route('person.show', ['person' => $person]));

        $response->assertOk();
        $response->assertViewIs('persons.show');
        $response->assertViewHas('person');
        $response->assertViewHas('files');
        $response->assertViewHas('relationship_types');
        $response->assertViewHas('touchpoints');
        $response->assertViewHas('registrations');
        $response->assertSeeText($person->display_name);
    }

    /**
     * @test
     */
    public function staff_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('staff'));

        $response->assertOk();
        $response->assertViewIs('persons.role');
        $response->assertViewHas('persons');
        $response->assertViewHas('role');
        $response->assertSeeText('Staff');
    }

    /**
     * @test
     */
    public function stewards_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('stewards'));

        $response->assertOk();
        $response->assertViewIs('persons.role');
        $response->assertViewHas('persons');
        $response->assertViewHas('role');
        $response->assertSeeText('Steward');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-contact');

        $prefix = \App\Models\Prefix::get()->random();
        $suffix = \App\Models\Suffix::get()->random();
        $first_name = $this->faker->firstName;
        $last_name = $this->faker->lastName;
        $ethnicity = \App\Models\Ethnicity::get()->random();
        $religion = \App\Models\Religion::whereIsActive(1)->get()->random();
        $occupation = \App\Models\Ppd_occupation::get()->random();
        $preferred_language = \App\Models\Language::whereIsActive(1)->get()->random();

        $response = $this->actingAs($user)->post(route('person.store'), [
                'sort_name' => $last_name.', '.$first_name,
                '$display_name' => $first_name.' '.$last_name,
                'prefix_id' => $prefix->id,
                'first_name' => $first_name,
                'middle_name' => $this->faker->firstName,
                'last_name' => $last_name,
                'suffix_id' => $suffix->id,
                'nick_name' => $this->faker->name,
                'contact_type' => config('polanco.contact_type.individual'),
                'subcontact_type' => null,
                'gender_id' => $this->faker->numberBetween(1, 2),
                'birth_date' => $this->faker->dateTime,
                '$ethnicity_id' => $ethnicity->id,
                'religion_id' => $religion->id,
                'occupation_id' => $occupation->id,
                'preferred_language' => $preferred_language->name,
                'do_not_email' => $this->faker->boolean,
                'do_not_phone' => $this->faker->boolean,
                'do_not_mail' => $this->faker->boolean,
                'do_not_sms' => $this->faker->boolean,
                'do_not_trade' => $this->faker->boolean,
        ]);
        $person = \App\Models\Contact::whereSortName($last_name.', '.$first_name)->first();
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('PersonController@show', $person->id));
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PersonController::class,
            'store',
            \App\Http\Requests\StorePersonRequest::class
        );
    }

    /**
     * @test
     */
    public function superiors_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('superiors'));

        $response->assertOk();
        $response->assertViewIs('persons.role');
        $response->assertViewHas('persons');
        $response->assertViewHas('role');
        $response->assertSeeText('Superior');
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-contact');
        $person = \App\Models\Contact::factory()->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => null,
        ]);
        $original_sort_name = $person->sort_name;
        $new_sort_name = $this->faker->lastName.', '.$this->faker->firstName;

        $response = $this->actingAs($user)->put(route('person.update', [$person]), [
            'contact_type' => config('polanco.contact_type.individual'),
            'first_name' => $person->first_name,
            'last_name' => $person->last_name,
            'sort_name' => $new_sort_name,
        ]);

        $updated = \App\Models\Contact::findOrFail($person->id);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action('PersonController@show', $person->id));
        $this->assertEquals($updated->sort_name, $new_sort_name);
        $this->assertNotEquals($updated->sort_name, $original_sort_name);
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PersonController::class,
            'update',
            \App\Http\Requests\UpdatePersonRequest::class
        );
    }

    /**
     * @test
     */
    public function volunteers_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('volunteers'));

        $response->assertOk();
        $response->assertViewIs('persons.role');
        $response->assertViewHas('persons');
        $response->assertViewHas('role');
        $response->assertSeeText('Volunteer');
    }
}
