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

        // number of Ignatian Retreats per Month
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

        // AGC Number of Donors per FY
        $current_year = (date('m') > 6) ? date('Y') + 1 : date('Y');
        $number_of_years = 5;
        $average_donor_count = \App\Donation::orderBy('donation_date', 'desc')->whereIn('donation_description', ['Annual Giving', 'Endowment', 'Scholarship', 'Buildings & Maintenance'])->where('donation_date', '>=', ($current_year-($number_of_years+1)).'-07-01')->where('donation_date', '<', $current_year.'-07-01')->groupBy('contact_id')->get();
        // dd($average_donor_count);
        $years = array();
        for ($x = -$number_of_years; $x <= 0; $x++) {
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
            $donors[$label]['sum'] = $agc_donors->sum('donation_amount');

        }

        $average_donor_count = array_sum(array_column($donors,'count'))/count(array_column($donors,'count'));
        $average_agc_amount = array_sum(array_column($donors,'sum'))/count(array_column($donors,'sum'));
        foreach ($years as $year) {
            $label = $year->year;
            $prev_year = $year->copy()->subYear();
            $donors[$label]['average_count'] = $average_donor_count;
            $donors[$label]['average_amount'] = $average_agc_amount;
        }

        $agc_donor_chart = new RetreatOfferingChart;
        $agc_donor_chart->labels(array_keys($donors));
        $agc_donor_chart->dataset('AGC Donors per Year', 'line', array_column($donors,'count'));
        $agc_donor_chart->dataset('Average', 'line', array_column($donors,'average_count'));

        $agc_amount = new RetreatOfferingChart;
        $agc_amount->labels(array_keys($donors));
        $agc_amount->dataset('AGC Amount per Fiscal Year', 'line', array_column($donors,'sum'));
        $agc_amount->dataset('Average', 'line', array_column($donors,'average_amount'));


        return view('dashboard.index', compact('chart','agc_donor_chart','agc_amount'));
    }
}
