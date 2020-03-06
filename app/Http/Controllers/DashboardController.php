<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\RetreatOfferingChart;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $this->authorize('show-dashboard');


        $dates = array();
        for ($x = 0; $x <= 12; $x++) {
            $today = \Carbon\Carbon::now();
            $today->day = 1;
            $dates[$x] = $today->subMonth($x);
        }
        // dd($dates);

        $participants = array();

        foreach ($dates as $date) {
            $label = $date->month.'/'.$date->year;
            $next_month = $date->copy()->addMonth();

            $retreat = \App\Retreat::whereEventTypeId(config('polanco.event_type.ignatian'))->where('start_date','>=',$date)->where('start_date','<',$next_month)->with('retreatants')->get();

            $participants[$label] = $retreat->count();

        }

        $chart = new RetreatOfferingChart;
        $chart->labels(array_keys($participants));
        $chart->dataset('Ignatian Retreats per Month', 'bar', array_values($participants));

        $current_year = (date('m') > 6) ? date('Y') + 1 : date('Y');
        $years = array();
        for ($x = -6; $x <= 0; $x++) {
            $today = \Carbon\Carbon::now();
            $today->day = 1;
            $today->month = 1;
            $today->year = $current_year;
            $years[$x] = $today->addYear($x);
        }

        $donors = array();
        foreach ($years as $year) {
            $label = $year->year;
            $prev_year = $year->copy()->subYear();

            $agc_donors = \App\Donation::orderBy('donation_date', 'desc')->whereIn('donation_description', ['Annual Giving', 'Endowment', 'Scholarship', 'Buildings & Maintenance'])->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->groupBy('contact_id')->get();

            $donors[$label]['count'] = $agc_donors->count();
            $donors[$label]['average'] = 240.9;


        }

        $agc_donor_chart = new RetreatOfferingChart;
        $agc_donor_chart->labels(array_keys($donors));
        $agc_donor_chart->dataset('AGC Donors per Year', 'line', array_column($donors,'count'));
        $agc_donor_chart->dataset('Average', 'line', array_column($donors,'average'));


        return view('dashboard.index', compact('chart','agc_donor_chart'));
    }
}
