<?php

// TODO: Remove Donor tests as Donors are no longer used

namespace Tests\Feature\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DonorController
 */
final class DonorControllerTest extends TestCase
{
    // use DatabaseTransactions;

    #[Test]
    public function index_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-donor');

        $response = $this->actingAs($user)->get(route('donor.index'));

        $response->assertOk();
        $response->assertViewIs('donors.index');
        $response->assertViewHas('donors');
    }

    #[Test]
    public function show_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-donor');
        $contact = \App\Models\Contact::factory()->create([
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => null,
        ]);
        $donor = \App\Models\Donor::factory()->create([
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
    }

    // test cases...
}
