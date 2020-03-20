<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SearchController
 */
class SearchControllerTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function autocomplete_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');
        $lastname = $this->faker->lastName;
        $display_name = $this->faker->firstName.' '.$lastname;

        $person = factory(\App\Contact::class)->create([
            'display_name' => $display_name,
            'last_name' => $lastname,
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => null,
        ]);

        $response = $this->actingAs($user)->get('search/autocomplete?term='.$lastname);

        $response->assertOk();
        $response->assertJsonStructure([
            [
                'id',
                'value',
            ],
        ]);
        $response->assertSeeText($lastname);
    }

    /**
     * @test
     */
    public function getuser_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');
        $contact = factory(\App\Contact::class)->create();
        $response = $this->actingAs($user)->get('search/getuser?response='.$contact->id);

        $response->assertRedirect($contact->contact_url);
    }

    /**
     * @test
     */
    public function getuser_with_no_response_returns_create_response()
    {
        $user = $this->createUserWithPermission('show-contact');
        $response = $this->actingAs($user)->get('search/getuser?response=0');

        $response->assertRedirect(route('person.create'));
    }

    /**
     * @test
     */
    public function results_returns_an_ok_response()
    {   // create a new user and then search for that user's last name and ensure that a result appears
        $user = $this->createUserWithPermission('show-contact');

        $contact = factory(\App\Contact::class)->create();

        $response = $this->actingAs($user)->get('results?last_name='.$contact->last_name);

        $response->assertOk();
        $response->assertViewIs('search.results');
        $response->assertViewHas('persons');
        $response->assertSeeText('results found');
        $response->assertSeeText($contact->last_name);
    }

    /**
     * @test
     */
    public function search_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');

        $response = $this->actingAs($user)->get('search');

        $response->assertOk();
        $response->assertViewIs('search.search');
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
        $response->assertViewHas('groups');
        $response->assertViewHas('referrals');
        $response->assertSeeText('Search Contacts');
    }

    // test cases...
}
