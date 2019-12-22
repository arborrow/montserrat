<?php
// TODO: Remove Donor tests as Donors are no longer used
namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DonorController
 */
class DonorControllerTest extends TestCase
{
    // use RefreshDatabase;


    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-donor');

        $response = $this->actingAs($user)->get(route('donor.index'));

        $response->assertOk();
        $response->assertViewIs('donors.index');
        $response->assertViewHas('donors');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-donor');
        $contact = factory(\App\Contact::class)->create([
          'contact_type' => config('polanco.contact_type.individual'),
          'subcontact_type' => NULL,
        ]);
        $donor = factory(\App\Donor::class)->create([
          'contact_id' => $contact->id,
          'sort_name' => $contact->sort_name,
        ]);

        $response = $this->actingAs($user)->get(route('donor.show', $donor->donor_id));
        // dd($donor->sort_name);
        $response->assertOk();
        $response->assertViewIs('donors.show');
        $response->assertViewHas('donor');
        $response->assertViewHas('sortnames');
        $response->assertViewHas('lastnames');

        // TODO: perform additional assertions
    }

    // test cases...
}
