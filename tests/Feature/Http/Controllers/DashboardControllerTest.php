<?php

namespace Tests\Feature\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DashboardController
 */
class DashboardControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-dashboard');

        $response = $this->actingAs($user)->get(route('dashboard.index'));

        $response->assertOk();
        $response->assertViewIs('dashboard.index');
        $response->assertSee('Dashboard Index');
    }

    /**
     * @test
     */
    public function agc_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-dashboard');
        $response = $this->actingAs($user)->get(route('dashboard.agc'));

        $response->assertOk();
        $response->assertViewIs('dashboard.agc');
        $response->assertSee('AGC Dashboard');
    }

    /**
     * @test
     */
    public function donation_description_chart_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-dashboard');

        $response = $this->actingAs($user)->get(route('dashboard.description'));

        $response->assertOk();
        $response->assertViewIs('dashboard.description');
        $response->assertViewHas('descriptions');
        $response->assertSee('Donation Description Dashboard');
    }

    /**
     * @test
     */
    public function donation_description_chart_with_donation_description_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-dashboard');
        $donation_type = \App\Models\DonationType::active()->get()->random();
        $donation = \App\Models\Donation::factory()->create([
            'donation_description' => $donation_type->name,
        ]);

        $response = $this->actingAs($user)->get('/dashboard/description/'.$donation_type->id);

        $response->assertOk();
        $response->assertViewIs('dashboard.description');
        $response->assertViewHas('descriptions');
        $response->assertSee('Donation Description Dashboard');
        $response->assertSee($donation_type->name);
    }

    /**
     * @test
     */
    public function events_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-dashboard');

        $response = $this->actingAs($user)->get(route('dashboard.events'));

        $response->assertOk();
        $response->assertViewIs('dashboard.events');
        $response->assertViewHas('years');
        $response->assertViewHas('year');
        $response->assertViewHas('event_summary');
        $response->assertViewHas('total_revenue');
        $response->assertViewHas('total_participants');
        $response->assertViewHas('total_peoplenights');
        $response->assertSee('Event Dashboard');
    }

    /**
     * @test
     */
    public function events_with_year_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-dashboard');
        $last_year = Carbon::now()->subYear()->year;

        $response = $this->actingAs($user)->get('/dashboard/events/'.$last_year);

        $response->assertOk();
        $response->assertViewIs('dashboard.events');
        $response->assertViewHas('years');
        $response->assertViewHas('year');
        $response->assertViewHas('event_summary');
        $response->assertViewHas('total_revenue');
        $response->assertViewHas('total_participants');
        $response->assertViewHas('total_peoplenights');
        $response->assertSee('Event Dashboard');
        $response->assertSeeText('FY'.$last_year);
    }

    /**
     * @test
     */
    public function drilldown_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-dashboard');
        $event_type = \App\Models\EventType::get()->random();
        $response = $this->actingAs($user)->get(route('dashboard.drilldown', $event_type->id));

        $response->assertOk();
        $response->assertViewIs('dashboard.drilldown');
        $response->assertViewHas('year');
        $response->assertViewHas('retreats');
        $response->assertViewHas('event_type');
        $response->assertSee('Drilldown');
    }
}
