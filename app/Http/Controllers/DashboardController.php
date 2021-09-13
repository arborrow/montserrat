<?php

namespace App\Http\Controllers;

use App\Charts\RetreatOfferingChart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('show-dashboard');

        return view('dashboard.index');
    }

    public function agc()
    {   // polanco.cool_colors defines 9 different colors that can be used in generating charts, I take mod 8 to rotate through the first 8 colors and then repeat
        // TODO: get % of returning or % of last year but unfortunately not this year  between agc years
        $this->authorize('show-dashboard');
        $current_year = (date('m') > 6) ? date('Y') + 1 : date('Y');
        $number_of_years = 5;

        $years = [];
        for ($x = -$number_of_years; $x <= 0; $x++) {
            $today = \Carbon\Carbon::now();
            $today->day = 1;
            $today->month = 1;
            $today->year = $current_year;
            $years[$x] = $today->addYear($x);
        }

        $donors = [];
        foreach ($years as $year) {
            $label = $year->year;
            $prev_year = $year->copy()->subYear();
            // TODO: consider stepping throuh polanco.agc_donation_descriptions with a foreach to build collections - this will make this much more dynamic in the future
            $agc_donors['All'] = \App\Models\Donation::orderBy('donation_date', 'desc')->whereIn('donation_description', config('polanco.agc_donation_descriptions'))->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->groupBy('contact_id')->get();
            foreach (config('polanco.agc_donation_descriptions') as $description) {
                $agc_donors[$description] = \App\Models\Donation::orderBy('donation_date', 'desc')->whereDonationDescription($description)->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->groupBy('contact_id')->get();
            }

            $agc_donations['All'] = \App\Models\Donation::orderBy('donation_date', 'desc')->whereIn('donation_description', config('polanco.agc_donation_descriptions'))->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->get();
            foreach (config('polanco.agc_donation_descriptions') as $description) {
                $agc_donations[$description] = \App\Models\Donation::orderBy('donation_date', 'desc')->whereDonationDescription($description)->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->get();
            }

            //unique donors
            $donors[$label]['count'] = $agc_donors['All']->count();
            foreach (config('polanco.agc_donation_descriptions') as $description) {
                $donors[$label]['count_'.$description] = $agc_donors[$description]->count();
            }

            $donors[$label]['sum'] = $agc_donations['All']->sum('donation_amount');
            foreach (config('polanco.agc_donation_descriptions') as $description) {
                $donors[$label]['sum_'.$description] = $agc_donations[$description]->sum('donation_amount');
            }
        }
        $average_donor_count = (((array_sum(array_column($donors, 'count'))) - ($donors[$current_year]['count'])) / (count(array_column($donors, 'count')) - 1));
        $average_agc_amount = (((array_sum(array_column($donors, 'sum'))) - ($donors[$current_year]['sum'])) / (count(array_column($donors, 'sum')) - 1));

        foreach ($years as $year) {
            $label = $year->year;
            $prev_year = $year->copy()->subYear();
            $donors[$label]['average_count'] = $average_donor_count;
            $donors[$label]['average_amount'] = $average_agc_amount;
        }

        $agc_donor_chart = new RetreatOfferingChart;
        $agc_donor_chart->labels(array_keys($donors));
        $agc_donor_chart->options([
            'legend' => [
                'position' => 'bottom', // or false, depending on what you want.
            ],
        ]);

        $agc_donor_chart->dataset('Total Average', 'line', array_column($donors, 'average_count'));
        $agc_donor_chart->dataset('Total Donors per Year', 'line', array_column($donors, 'count'))
            ->color('rgba(22,160,133, 1.0)')
            ->backgroundcolor('rgba(22,160,133, 0.2');
        foreach (config('polanco.agc_donation_descriptions') as $key=>$description) {
            $agc_donor_chart->dataset($description, 'line', array_column($donors, 'count_'.$description))
                ->color('rgba('.config('polanco.agc_cool_colors')[$key % 8].', 0.8)')
                ->backgroundcolor('rgba('.config('polanco.agc_cool_colors')[$key % 8].', 0.2)');
        }

        $agc_amount = new RetreatOfferingChart;
        $agc_amount->options([
            'legend' => [
                'position' => 'bottom', // or false, depending on what you want.
            ],
        ]);
        $agc_amount->labels(array_keys($donors));
        $agc_amount->dataset('Total Average', 'line', array_column($donors, 'average_amount'));
        $agc_amount->dataset('Total Donations per Year', 'line', array_column($donors, 'sum'))
            ->color('rgba(22,160,133, 1.0)')
            ->backgroundcolor('rgba(22,160,133, 0.2');
        foreach (config('polanco.agc_donation_descriptions') as $key=>$description) {
            $agc_amount->dataset($description, 'line', array_column($donors, 'sum_'.$description))
                ->color('rgba('.config('polanco.agc_cool_colors')[$key % 8].', 1.0)')
                ->backgroundcolor('rgba('.config('polanco.agc_cool_colors')[$key % 8].', 0.2');
        }

        return view('dashboard.agc', compact('agc_donor_chart', 'agc_amount'));
    }

    public function donation_description_chart($donation_description = 'Retreat Funding')
    {
        $this->authorize('show-dashboard');

        $descriptions = \App\Models\DonationType::active()->orderBy('name')->pluck('name', 'name');

        $current_year = (date('m') > 6) ? date('Y') + 1 : date('Y');
        $number_of_years = 5;
        $years = [];
        for ($x = -$number_of_years; $x <= 0; $x++) {
            $today = \Carbon\Carbon::now();
            $today->day = 1;
            $today->month = 1;
            $today->year = $current_year;
            $years[$x] = $today->addYear($x);
        }

        foreach ($years as $year) {
            $label = $year->year;
            $prev_year = $year->copy()->subYear();
            $donations = \App\Models\Donation::whereDonationDescription($donation_description)->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->get();
            $donors[$label]['count'] = $donations->count();
            $donors[$label]['sum'] = $donations->sum('donation_amount');
        }
        $average_amount = ((((array_sum(array_column($donors, 'sum'))) - ($donors[$current_year]['sum'])) / ($number_of_years)));

        foreach ($years as $year) {
            $label = $year->year;
            $prev_year = $year->copy()->subYear();
            $donors[$label]['average_amount'] = $average_amount;
        }
        $donation_description_chart = new RetreatOfferingChart;
        $donation_description_chart->labels(array_keys($donors));
        $donation_description_chart->options([
            'legend' => [
                'position' => 'bottom', // or false, depending on what you want.
            ],
        ]);
        $donation_description_chart->dataset('Average', 'line', array_column($donors, 'average_amount'));
        $donation_description_chart->dataset('Donations for '.$donation_description, 'line', array_column($donors, 'sum'))
            ->color('rgba(22,160,133, 1.0)')
            ->backgroundcolor('rgba(22,160,133, 0.5)');

        return view('dashboard.description', compact('donation_description_chart', 'descriptions'));
    }

    public function board($year = null)
    {
        // TODO: Create donut chart for average number of retreatants per event (get count of event_type_id) partipants/count(event_type_id) //useful for Ambassador goal of 40 (draw goal line)
        $this->authorize('show-dashboard');

        // default to current fiscal year
        if (! isset($year)) {
            $year = (date('m') > 6) ? date('Y') + 1 : date('Y');
        }

        $current_year = (date('m') > 6) ? date('Y') + 1 : date('Y');
        $prev_year = $year - 1;
        $begin_date = $prev_year.'-07-01';
        $end_date = $year.'-07-01';

        $number_of_years = 5;
        $years = [];
        for ($x = 0; $x <= $number_of_years; $x++) {
            $today = \Carbon\Carbon::now();
            $today->day = 1;
            $today->month = 1;
            $today->year = $current_year;
            $years[$x] = $today->subYear($x);
        }

        $borderColors = [
           'rgba(255, 99, 132, 1.0)',
           'rgba(22,160,133, 1.0)',
           'rgba(255, 205, 86, 1.0)',
           'rgba(51,105,232, 1.0)',
           'rgba(244,67,54, 1.0)',
           'rgba(34,198,246, 1.0)',
           'rgba(153, 102, 255, 1.0)',
           'rgba(255, 159, 64, 1.0)',
           'rgba(233,30,99, 1.0)',
           'rgba(205,220,57, 1.0)',
       ];
        $fillColors = [
           'rgba(255, 99, 132, 0.5)',
           'rgba(22,160,133, 0.5)',
           'rgba(255, 205, 86, 0.5)',
           'rgba(51,105,232, 0.5)',
           'rgba(244,67,54, 0.5)',
           'rgba(34,198,246, 0.5)',
           'rgba(153, 102, 255, 0.5)',
           'rgba(255, 159, 64, 0.5)',
           'rgba(233,30,99, 0.5)',
           'rgba(205,220,57, 0.5)',

       ];

       // TODO: using role_id = 5 as hardcoded value - explore how to use config('polanco.participant_role_id.retreatant') instead
        $board_summary = DB::select("SELECT tmp.type, SUM(tmp.pledged) as total_pledged, SUM(tmp.paid) as total_paid, SUM(tmp.participants) as total_participants, SUM(tmp.peoplenights) as total_pn, SUM(tmp.nights) as total_nights
            FROM
            (SELECT e.id as event_id, e.title as event, et.name as type, e.idnumber, e.start_date, e.end_date, DATEDIFF(e.end_date,e.start_date) as nights,
            	(SELECT SUM(d.donation_amount) FROM Donations as d WHERE d.event_id=e.id) as pledged,
            	(SELECT SUM(p.payment_amount) FROM Donations as d LEFT JOIN Donations_payment as p ON (p.donation_id = d.donation_id) WHERE d.event_id=e.id AND d.deleted_at IS NULL AND p.deleted_at IS NULL) as paid,
            	(SELECT COUNT(*) FROM participant as reg WHERE reg.event_id = e.id AND reg.deleted_at IS NULL AND reg.canceled_at IS NULL AND reg.role_id IN (5,11)) AND reg.status_id IN (1) as participants,
            	(SELECT(participants*nights)) as peoplenights
            FROM event as e LEFT JOIN event_type as et ON (et.id = e.event_type_id)
            WHERE e.start_date > :begin_date AND e.start_date < :end_date AND e.is_active=1 AND e.deleted_at IS NULL AND e.title NOT LIKE '%Deposit%'
            GROUP BY e.id) as tmp
            GROUP BY tmp.type
            ORDER BY `tmp`.`type` ASC", [
                'begin_date' => $begin_date,
                'end_date' => $end_date,
            ]);

        $total_revenue = array_sum(array_column($board_summary, 'total_paid'));
        $total_participants = array_sum(array_column($board_summary, 'total_participants'));
        $total_peoplenights = array_sum(array_column($board_summary, 'total_pn'));

        $board_summary_revenue_chart = new RetreatOfferingChart;
        $board_summary_revenue_chart->labels(array_column($board_summary, 'type'));
        $board_summary_revenue_chart->options([
            'legend' => [
                'position' => 'bottom',
            ],
        ]);

        $board_summary_revenue_chart->dataset('FY20 Revenue by Event Type', 'doughnut', array_column($board_summary, 'total_paid'))
            ->color($borderColors)
            ->backgroundcolor($fillColors);
        // $board_summary_revenue_chart->displayLegend(true);
        //$board_summary_revenue_chart->minimalist(false);
        // $board_summary_revenue_chart->plugins([
        //    'plugins' => '{datalabels: {color: \'red\'}}',
        // ]);

        $board_summary_participant_chart = new RetreatOfferingChart;
        $board_summary_participant_chart->labels(array_column($board_summary, 'type'));
        $board_summary_participant_chart->options([
            'legend' => [
                'position' => 'bottom', // or false, depending on what you want.
            ],
        ]);
        $board_summary_participant_chart->dataset('FY20 Participants by Event Type', 'doughnut', array_column($board_summary, 'total_participants'))
            ->color($borderColors)
            ->backgroundcolor($fillColors);

        $board_summary_peoplenight_chart = new RetreatOfferingChart;
        $board_summary_peoplenight_chart->labels(array_column($board_summary, 'type'));
        $board_summary_peoplenight_chart->options([
            'legend' => [
                'position' => 'bottom', // or false, depending on what you want.
            ],
        ]);
        $board_summary_peoplenight_chart->dataset('FY20 People Nights by Event Type', 'doughnut', array_column($board_summary, 'total_pn'))
            ->color($borderColors)
            ->backgroundcolor($fillColors);
        $summary = array_values($board_summary);

        return view('dashboard.board', compact('years', 'year', 'summary', 'board_summary', 'board_summary_revenue_chart', 'board_summary_participant_chart', 'board_summary_peoplenight_chart', 'total_revenue', 'total_participants', 'total_peoplenights'));
    }
}
