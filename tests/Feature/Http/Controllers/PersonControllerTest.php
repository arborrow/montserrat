<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PersonController
 */
class PersonControllerTest extends TestCase
{

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

        // dd($response);

        // TODO: perform additional assertions
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
    public function captains_returns_an_ok_response()
    {
      $user = $this->createUserWithPermission('show-contact');

      $response = $this->actingAs($user)->get(route('captains'));

      $response->assertOk();
      $response->assertViewIs('persons.role');
      $response->assertViewHas('persons');
      $response->assertViewHas('role');
      $response->assertSeeText('Captain');

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
        $person = factory(\App\Contact::class)->create([
          'contact_type' => '1',
          'subcontact_type' => NULL,
        ]);

        $response = $this->actingAs($user)->delete(route('person.destroy', ['person' => $person]));

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
        $person = factory(\App\Contact::class)->create([
          'contact_type' => '1',
          'subcontact_type' => NULL,
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
        $response->assertSee(e($person->display_name));
    }

    /**
     * @test
     */
    public function envelope_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('envelope', ['id' => $id]));

        $response->assertRedirect(action('PersonController@show', $person->id));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_displays_paginated_contacts_contacts()
    {
        $contact = factory(\App\Contact::class)->create([
            'contact_type' => config('polanco.contact_type.individual')
        ]);

        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get(route('person.index'));

        $response->assertOk();
        $response->assertViewIs('persons.index');
        $response->assertViewHas('persons');

        // verify that at least one contact is on the list
        // verify contact created with this test is returned as part of the persons.index results
        // n.b. - this could fail if there are more than the paginated number of contacts with the created contact on another page
        $persons = $response->viewData('persons');
        $person = $persons->find($contact->id);
        $count_persons = $persons->count();
        $this->assertGreaterThanOrEqual('1',$count_persons);
        $this->assertEquals($contact->id, $person->id);
    }

    /**
     * @test
     */
    public function index_returns_403_without_proper_permission()
    {
        $user = factory(\App\User::class)->create();

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
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)->get(route('lastnames'));

        $response->assertOk();
        $response->assertViewIs('persons.index');
        $response->assertViewHas('persons');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function merge_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)->get(route('merge', ['contact_id' => $contact_id]));

        $response->assertRedirect(action('PersonController@duplicates'));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function merge_destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)->get(route('merge_delete', ['id' => $id, 'return_id' => $return_id]));

        $response->assertRedirect(action('PersonController@merge', $return_id));

        // TODO: perform additional assertions
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
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)->get(route('person.show', ['person' => $person]));

        $response->assertOk();
        $response->assertViewIs('persons.show');
        $response->assertViewHas('person');
        $response->assertViewHas('files');
        $response->assertViewHas('relationship_types');
        $response->assertViewHas('touchpoints');
        $response->assertViewHas('registrations');

        // TODO: perform additional assertions
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
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)->post(route('person.store'), [
            // TODO: send request data
        ]);

        $response->assertRedirect(action('PersonController@show', $person->id));

        // TODO: perform additional assertions
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
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)->put(route('person.update', ['person' => $person]), [
            // TODO: send request data
        ]);

        $response->assertRedirect(action('PersonController@show', $person->id));

        // TODO: perform additional assertions
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
