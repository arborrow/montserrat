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

        return view('dashboard.index', compact('chart'));
    }
}
