<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\TmpOfferingDedup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SystemController
 */
class SystemControllerTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function offeringdedup_index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-offeringdedup');

        $response = $this->actingAs($user)->get(route('offeringdedup'));

        $response->assertOk();
        $response->assertViewIs('offeringdedup.index');
        $response->assertViewHas('offeringdedup');
        $response->assertSee('Offering Dedup');
    }

    /**
     * @test
     */
    public function offeringdedup_show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-offeringdedup');

        // Create a duplicate contact_id:event_id pair of donations
        $offeringdedup = factory(\App\Models\TmpOfferingDedup::class)->create([
            'created_at' => $this->faker->dateTime('now'),
        ]);
        $donation_1 = factory(\App\Models\Donation::class)->create([
          'contact_id' => $offeringdedup->contact_id,
          'event_id' => $offeringdedup->event_id,
          'donation_description' => 'Retreat Funding',
        ]);
        $donation_2 = factory(\App\Models\Donation::class)->create([
          'contact_id' => $offeringdedup->contact_id,
          'event_id' => $offeringdedup->event_id,
          'donation_description' => 'Retreat Funding',
        ]);

        $response = $this->actingAs($user)->get(route('offeringdedup.show', ['contact_id' => $offeringdedup->contact_id, 'event_id' => $offeringdedup->event_id]));

        $response->assertOk();
        $response->assertViewIs('offeringdedup.show');
        $response->assertViewHas('donations');
        $response->assertViewHas('combo');
        $response->assertSee('Offering Dedup Details');
    }

    /**
     * @test
     */
    public function phpinfo_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-admin-menu');

        $response = $this->actingAs($user)->get(route('phpinfo'));

        $response->assertOk();
        $response->assertViewIs('admin.config.phpinfo');
        $response->assertSee('PHP Version');
    }
}
