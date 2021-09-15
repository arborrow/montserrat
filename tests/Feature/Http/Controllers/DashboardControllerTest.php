<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;

/**
 * @see \App\Http\Controllers\DashboardController
 */
class DashboardControllerTest extends TestCase
{
    use WithFaker;

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
        $response->assertViewHas('agc_donor_chart');
        $response->assertViewHas('agc_amount');
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
        $response->assertViewHas('donation_description_chart');
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

            $response = $this->actingAs($user)->get('/dashboard/description/'.$donation_type->name);

            $response->assertOk();
            $response->assertViewIs('dashboard.description');
            $response->assertViewHas('donation_description_chart');
            $response->assertViewHas('descriptions');
            $response->assertSee('Donation Description Dashboard');
            $response->assertSee($donation_type->name);

        }

    /**
     * @test
     */
    public function board_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-dashboard');

        $response = $this->actingAs($user)->get(route('dashboard.board'));

        $response->assertOk();
        $response->assertViewIs('dashboard.board');
        $response->assertViewHas('years');
        $response->assertViewHas('year');
        $response->assertViewHas('summary');
        $response->assertViewHas('board_summary');
        $response->assertViewHas('board_summary_revenue_chart');
        $response->assertViewHas('board_summary_participant_chart');
        $response->assertViewHas('board_summary_peoplenight_chart');
        $response->assertViewHas('total_revenue');
        $response->assertViewHas('total_participants');
        $response->assertViewHas('total_peoplenights');
        $response->assertSee('Board Dashboard');
    }

    /**
     * @test
     */
    public function board_with_year_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-dashboard');
        $last_year = Carbon::now()->subYear()->year;

        $response = $this->actingAs($user)->get('/dashboard/board/'.$last_year);

        $response->assertOk();
        $response->assertViewIs('dashboard.board');
        $response->assertViewHas('years');
        $response->assertViewHas('year');
        $response->assertViewHas('summary');
        $response->assertViewHas('board_summary');
        $response->assertViewHas('board_summary_revenue_chart');
        $response->assertViewHas('board_summary_participant_chart');
        $response->assertViewHas('board_summary_peoplenight_chart');
        $response->assertViewHas('total_revenue');
        $response->assertViewHas('total_participants');
        $response->assertViewHas('total_peoplenights');
        $response->assertSee('Board Dashboard');
        $response->assertSeeText("FY".$last_year);

    }

    /**
     * @test
     */
    public function drilldown_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-dashboard');
        $event_type = \App\Models\EventType::get()->random();
        $response = $this->actingAs($user)->get(route('dashboard.drilldown',$event_type->id));

        $response->assertOk();
        $response->assertViewIs('dashboard.drilldown');
        $response->assertViewHas('year');
        $response->assertViewHas('retreats');
        $response->assertViewHas('event_type');
        $response->assertSee('Drilldown');
    }


}
