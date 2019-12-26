<?php

namespace Tests\Feature\Http\Controllers;

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
        $user = $this->createUserWithPermission('show-contact');
        $person = factory(\App\Contact::class)->create([
          'contact_type' => '1',
          'subcontact_type' => NULL,
        ]);

        $response = $this->actingAs($user)->get(route('envelope', ['id' => $person->id]));

        $response->assertViewIs('persons.envelope10');
        $response->assertSee(e($person->agc_household_name));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_displays_paginated_contacts_contacts()
    {
        $person = factory(\App\Contact::class)->create([
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => NULL,
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
        $count_persons = $persons->count();
        $this->assertGreaterThanOrEqual('1',$count_persons);
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
        $user = $this->createUserWithPermission('show-contact');
        $person = factory(\App\Contact::class)->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => NULL,
        ]);

        $response = $this->actingAs($user)->get(route('lastnames'),[
            'lastname' => substr($person->last_name,0,1),
          ]);
        $persons = $response->viewData('persons');

        $response->assertOk();
        $response->assertViewIs('persons.index');
        $response->assertViewHas('persons');
        $this->assertGreaterThanOrEqual('1',$persons->count());

    }

    /**
     * @test
     */
    public function merge_returns_an_ok_response()
    {
        $user = factory(\App\User::class)->create();
        $user->assignRole('test-role:merge');

        $person = factory(\App\Contact::class)->create([
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => NULL,
        ]);

        $duplicate_person = factory(\App\Contact::class)->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => NULL,
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
    public function merge_destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-contact');
        $person = factory(\App\Contact::class)->create([
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => NULL,
        ]);

        $duplicate_person = factory(\App\Contact::class)->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => NULL,
          'sort_name' => $person->sort_name,
        ]);

        $response = $this->actingAs($user)->get(route('merge_delete', ['id' => $duplicate_person->id, 'return_id' => $person->id]));

        $response->assertRedirect(action('PersonController@merge', $person->id));
        $this->assertSoftDeleted($duplicate_person);

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
        $user = $this->createUserWithPermission('show-contact');
        $person = factory(\App\Contact::class)->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => NULL,
        ]);

        $response = $this->actingAs($user)->get(route('person.show', ['person' => $person]));

        $response->assertOk();
        $response->assertViewIs('persons.show');
        $response->assertViewHas('person');
        $response->assertViewHas('files');
        $response->assertViewHas('relationship_types');
        $response->assertViewHas('touchpoints');
        $response->assertViewHas('registrations');
        $response->assertSeeText(e($person->display_name));
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

        $prefix = \App\Prefix::get()->random();
        $suffix = \App\Suffix::get()->random();
        $first_name = $this->faker->firstName;
        $last_name = $this->faker->lastName;
        $ethnicity = \App\Ethnicity::get()->random();
        $religion = \App\Religion::whereIsActive(1)->get()->random();
        $occupation = \App\Ppd_occupation::get()->random();

        $response = $this->actingAs($user)->post(route('person.store'), [
                'sort_name' => $last_name . ', ' . $first_name,
                '$display_name' => $first_name . ' ' . $last_name,
                'prefix_id' => $prefix->id,
                'first_name' => $first_name,
                'middle_name' => $this->faker->firstName,
                'last_name' => $last_name,
                'suffix_id' => $suffix->id,
                'nick_name' => $this->faker->name,
                'contact_type' => config('polanco.contact_type.individual'),
                'subcontact_type' => NULL,
                'gender_id' => $this->faker->numberBetween(1,2),
                'birth_date' => $this->faker->dateTime,
                '$ethnicity_id' => $ethnicity->id,
                'religion_id' => $religion->id,
                'occupation_id' => $occupation->id,
                'preferred_language' => $this->faker->locale,
                'do_not_email' => $this->faker->boolean,
                'do_not_phone' => $this->faker->boolean,
                'do_not_mail' => $this->faker->boolean,
                'do_not_sms' => $this->faker->boolean,
                'do_not_trade' => $this->faker->boolean,
        ]);
        $person = \App\Contact::whereSortName($last_name . ', ' . $first_name)->first();
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
        $person = factory(\App\Contact::class)->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => NULL,
        ]);
        $original_sort_name = $person->sort_name;
        $new_sort_name = $this->faker->lastName . ', ' . $this->faker->firstName;

        $response = $this->actingAs($user)->put(route('person.update', [$person]), [
            'first_name' => $person->first_name,
            'last_name' => $person->last_name,
            'sort_name' => $new_sort_name,
        ]);

        $updated = \App\Contact::findOrFail($person->id);

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
