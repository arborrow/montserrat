<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SearchController
 */
class SearchControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function autocomplete_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-contact');
        $lastname = $this->faker->lastName();
        $display_name = $this->faker->firstName().' '.$lastname;

        $person = \App\Models\Contact::factory()->create([
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
        $contact = \App\Models\Contact::factory()->create();
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
        $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('show-contact');

        $contact = \App\Models\Contact::factory()->create();

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
        $response->assertViewHas('contact_types');
        $response->assertViewHas('countries');
        $response->assertViewHas('ethnicities');
        $response->assertViewHas('genders');
        $response->assertViewHas('groups');
        $response->assertViewHas('languages');
        $response->assertViewHas('occupations');
        $response->assertViewHas('parish_list');
        $response->assertViewHas('prefixes');
        $response->assertViewHas('referrals');
        $response->assertViewHas('religions');
        $response->assertViewHas('states');
        $response->assertViewHas('subcontact_types');
        $response->assertViewHas('suffixes');

        $response->assertSeeText('Search Contacts');
    }

    // test cases...
}
