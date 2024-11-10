<?php

namespace Tests\Feature\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
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

    #[Test]
    public function index_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-dashboard');

        $response = $this->actingAs($user)->get(route('dashboard.index'));

        $response->assertOk();
        $response->assertViewIs('dashboard.index');
        $response->assertSee('Dashboard Index');
    }

    #[Test]
    public function agc_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-dashboard');
        $response = $this->actingAs($user)->get(route('dashboard.agc'));

        $response->assertOk();
        $response->assertViewIs('dashboard.agc');
        $response->assertSee('AGC Dashboard');
    }

    #[Test]
    public function agc_donations_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-donation');
        $response = $this->actingAs($user)->get(route('dashboard.agc_donations'));

        $response->assertOk();
        $response->assertViewIs('donations.results');
        $response->assertViewHas('donations');
        $response->assertViewHas('all_donations');
        $response->assertSee('result(s) found');
    }

    #[Test]
    public function agc_donations_returns_403_response(): void
    {   // requires show-donation permission, so ensure a 403 when that permission is missing
        $user = $this->createUserWithPermission('show-dashboard');
        $response = $this->actingAs($user)->get(route('dashboard.agc_donations'));

        $response->assertStatus(403);
    }

    #[Test]
    public function agc_with_years_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-dashboard');
        $current_fiscal_year = (date('m') > 6) ? date('Y') + 1 : date('Y');
        $number_of_years = $this->faker->numberBetween(5, 10);

        $response = $this->actingAs($user)->get(route('dashboard.agc', $number_of_years));

        $response->assertOk();
        $response->assertViewIs('dashboard.agc');
        $response->assertSee('AGC Dashboard');
        $response->assertSee($current_fiscal_year);
        $response->assertSee($current_fiscal_year - $number_of_years);
    }

    #[Test]
    public function donation_description_chart_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-dashboard');

        $response = $this->actingAs($user)->get(route('dashboard.description'));

        $response->assertOk();
        $response->assertViewIs('dashboard.description');
        $response->assertViewHas('descriptions');
        $response->assertSee('Donation Description Dashboard');
    }

    #[Test]
    public function donation_description_chart_with_donation_description_returns_an_ok_response(): void
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

    #[Test]
    public function events_returns_an_ok_response(): void
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

    #[Test]
    public function events_with_year_returns_an_ok_response(): void
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

    #[Test]
    public function drilldown_returns_an_ok_response(): void
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
