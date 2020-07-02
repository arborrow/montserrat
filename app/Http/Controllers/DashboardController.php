<?php

namespace App\Http\Controllers;

use App\Charts\RetreatOfferingChart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $this->authorize('show-dashboard');
        return view('dashboard.index');
    }

    public function agc()
    {
        // TODO: get % of returning or % of last year but unfortunately not this year  between agc years
        $this->authorize('show-dashboard');

        // number of Ignatian Retreats per Month
        $dates = [];
        for ($x = 0; $x <= 12; $x++) {
            $today = \Carbon\Carbon::now();
            $today->day = 1;
            $dates[$x] = $today->subMonth($x);
        }
        // dd($dates);

        $participants = [];

        foreach ($dates as $date) {
            $label = $date->month.'/'.$date->year;
            $next_month = $date->copy()->addMonth();

            $retreat = \App\Retreat::whereEventTypeId(config('polanco.event_type.ignatian'))->where('start_date', '>=', $date)->where('start_date', '<', $next_month)->with('retreatants')->get();

            $participants[$label] = $retreat->count();
        }

        $chart = new RetreatOfferingChart;
        $chart->labels(array_keys($participants));
        $chart->dataset('Ignatian Retreats per Month', 'bar', array_values($participants))
            ->color('rgba(255, 205, 86, 1.0)')
            ->backgroundcolor('rgba(255, 205, 86, 0.5)');

        // AGC Number of Donors per FY
        $current_year = (date('m') > 6) ? date('Y') + 1 : date('Y');
        $number_of_years = 5;
        $average_donor_count = \App\Donation::orderBy('donation_date', 'desc')->whereIn('donation_description', ['Annual Giving', 'Endowment', 'Scholarship', 'Buildings & Maintenance'])->where('donation_date', '>=', ($current_year - ($number_of_years + 1)).'-07-01')->where('donation_date', '<', $current_year.'-07-01')->groupBy('contact_id')->get();
        $average_donor_giving = \App\Donation::orderBy('donation_date', 'desc')->whereDonationDescription('Annual Giving')->where('donation_date', '>=', ($current_year - ($number_of_years + 1)).'-07-01')->where('donation_date', '<', $current_year.'-07-01')->groupBy('contact_id')->get();
        $average_donor_endowment = \App\Donation::orderBy('donation_date', 'desc')->whereDonationDescription('Endowment')->where('donation_date', '>=', ($current_year - ($number_of_years + 1)).'-07-01')->where('donation_date', '<', $current_year.'-07-01')->groupBy('contact_id')->get();
        $average_donor_scholarship = \App\Donation::orderBy('donation_date', 'desc')->whereDonationDescription('Scholarship')->where('donation_date', '>=', ($current_year - ($number_of_years + 1)).'-07-01')->where('donation_date', '<', $current_year.'-07-01')->groupBy('contact_id')->get();
        $average_donor_building = \App\Donation::orderBy('donation_date', 'desc')->whereDonationDescription('Buildings & Maintenance')->where('donation_date', '>=', ($current_year - ($number_of_years + 1)).'-07-01')->where('donation_date', '<', $current_year.'-07-01')->groupBy('contact_id')->get();
        // dd($average_donor_count);
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

            $agc_donors = \App\Donation::orderBy('donation_date', 'desc')->whereIn('donation_description', ['Annual Giving', 'Endowment', 'Scholarship', 'Buildings & Maintenance'])->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->groupBy('contact_id')->get();
            $agc_donors_giving = \App\Donation::orderBy('donation_date', 'desc')->whereDonationDescription('Annual Giving')->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->groupBy('contact_id')->get();
            $agc_donors_endowment = \App\Donation::orderBy('donation_date', 'desc')->whereDonationDescription('Endowment')->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->groupBy('contact_id')->get();
            $agc_donors_scholarship = \App\Donation::orderBy('donation_date', 'desc')->whereDonationDescription('Scholarship')->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->groupBy('contact_id')->get();
            $agc_donors_building = \App\Donation::orderBy('donation_date', 'desc')->whereDonationDescription('Buildings & Maintenance')->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->groupBy('contact_id')->get();

            $agc_donations = \App\Donation::orderBy('donation_date', 'desc')->whereIn('donation_description', ['Annual Giving', 'Endowment', 'Scholarship', 'Buildings & Maintenance'])->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->get();
            $agc_donations_giving = \App\Donation::orderBy('donation_date', 'desc')->whereDonationDescription('Annual Giving')->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->get();
            $agc_donations_endowment = \App\Donation::orderBy('donation_date', 'desc')->whereDonationDescription('Endowment')->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->get();
            $agc_donations_scholarship = \App\Donation::orderBy('donation_date', 'desc')->whereDonationDescription('Scholarship')->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->get();
            $agc_donations_building = \App\Donation::orderBy('donation_date', 'desc')->whereDonationDescription('Buildings & Maintenance')->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->get();

            //unique donors
            $donors[$label]['count'] = $agc_donors->count();
            $donors[$label]['count_giving'] = $agc_donors_giving->count();
            $donors[$label]['count_endowment'] = $agc_donors_endowment->count();
            $donors[$label]['count_scholarship'] = $agc_donors_scholarship->count();
            $donors[$label]['count_building'] = $agc_donors_building->count();

            $donors[$label]['sum'] = $agc_donations->sum('donation_amount');
            $donors[$label]['sum_giving'] = $agc_donations_giving->sum('donation_amount');
            $donors[$label]['sum_endowment'] = $agc_donations_endowment->sum('donation_amount');
            $donors[$label]['sum_scholarship'] = $agc_donations_scholarship->sum('donation_amount');
            $donors[$label]['sum_building'] = $agc_donations_building->sum('donation_amount');
        }

        $average_donor_count = array_sum(array_column($donors, 'count')) / count(array_column($donors, 'count'));
        $average_agc_amount = array_sum(array_column($donors, 'sum')) / count(array_column($donors, 'sum'));
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
        $agc_donor_chart->dataset('Annual Giving Donors', 'line', array_column($donors, 'count_giving'))
            ->color('rgba(51,105,232, 1.0)')
            ->backgroundcolor('rgba(51,105,232, 0.2');
        $agc_donor_chart->dataset('Endowment Donors', 'line', array_column($donors, 'count_endowment'))
            ->color('rgba(255, 205, 86, 1.0)')
            ->backgroundcolor('rgba(255, 205, 86, 132, 0.4');
        $agc_donor_chart->dataset('Scholarship Donors', 'line', array_column($donors, 'count_scholarship'))
            ->color('rgba(255, 99, 132, 1.0)')
            ->backgroundcolor('rgba(255, 99, 132, 0.2');
        $agc_donor_chart->dataset('Building & Maintenance Donors', 'line', array_column($donors, 'count_building'))
            ->color('rgba(244,67,54, 1.0)')
            ->backgroundcolor('rgba(244,67,54, 0.2');

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
        $agc_amount->dataset('Annual Giving', 'line', array_column($donors, 'sum_giving'))
            ->color('rgba(51,105,232, 1.0)')
            ->backgroundcolor('rgba(51,105,232, 0.2');
        $agc_amount->dataset('Endowment', 'line', array_column($donors, 'sum_endowment'))
            ->color('rgba(255, 205, 86, 1.0)')
            ->backgroundcolor('rgba(255, 205, 86, 132, 0.4');
        $agc_amount->dataset('Scholarship', 'line', array_column($donors, 'sum_scholarship'))
            ->color('rgba(255, 99, 132, 1.0)')
            ->backgroundcolor('rgba(255, 99, 132, 0.2');
        $agc_amount->dataset('Building & Maintenance', 'line', array_column($donors, 'sum_building'))
            ->color('rgba(244,67,54, 1.0)')
            ->backgroundcolor('rgba(244,67,54, 0.2');

        return view('dashboard.agc', compact('chart', 'agc_donor_chart', 'agc_amount'));
    }

    public function donation_description_chart($category = null)
    {
        $this->authorize('show-dashboard');

        switch ($category) {
            case 'bookstore': $donation_description = 'Bookstore'; break;
            case 'deposit': $donation_description = 'Deposit'; break;
            case 'diocese': $donation_description = 'Diocesan/Provincial/Parish Retreats'; break;
            case 'donation': $donation_description = 'Donation'; break;
            case 'flower': $donation_description = 'Flowers and Landscape'; break;
            case 'gift': $donation_description = 'Gift Certificate Purchase'; break;
            case 'other': $donation_description = 'Other Retreats'; break;
            case 'offering': $donation_description = 'Retreat Offering'; break;
            case 'tip': $donation_description = 'Tips'; break;
            default: $donation_description = 'Retreat Offering';
        }
        // dd($donation_description);
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
            $donations = \App\Donation::whereDonationDescription($donation_description)->where('donation_date', '>=', $prev_year->year.'-07-01')->where('donation_date', '<', $year->year.'-07-01')->get();
            $donors[$label]['count'] = $donations->count();
            $donors[$label]['sum'] = $donations->sum('donation_amount');
        }

        $average_amount = (array_sum(array_column($donors, 'sum')) / ($number_of_years + 1));
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

        $descriptions = [['bookstore', 'deposit', 'diocese', 'donation', 'flower', 'gift', 'offering', 'tip']];

        return view('dashboard.description', compact('donation_description_chart', 'descriptions'));
    }

    public function board($start = null, $end=null)
    {
        // TODO: Create donut chart for average number of retreatants per event (get count of event_type_id) partipants/count(event_type_id) //useful for Ambassador goal of 40 (draw goal line)
        $this->authorize('show-dashboard');
        if (! is_null($start)) {
            try {
                $start_date = Carbon::createFromFormat('Ymd', $start);
            } catch (\Exception $e) {
                echo 'Start date not formatted as yyyymmdd';
                return redirect(url('dashboard'));
            }
        }
        if (! is_null($end)) {
            try {
                $end_date = Carbon::createFromFormat('Ymd', $end);
            } catch (\Exception $e) {
                echo 'End date not formatted as yyyymmdd';
                return redirect()->back();
            }
        }

        // default to current fiscal year
        // if just a start date is given assume fiscal year for start date

        $start_date = is_null($start) ?  Carbon::today() : Carbon::createFromFormat('Ymd', $start);
        $end_date = is_null($end) ?  null : Carbon::createFromFormat('Ymd', $end);


        //calculate the fiscal year of the start date
        $fiscal_year = ($start_date->month > 6) ? $start_date->year + 1 : $start_date->year;
        $start_year = $fiscal_year - 1;

        // if there is no specific end date then assume fiscal year
        if (is_null($end_date)) {
            $start_date->month = 7;
            $start_date->day = 1;
            $start_date->year = $start_year;
            $end_date = new \Carbon\Carbon();
            $end_date->month = 7;
            $end_date->day = 1;
            $end_date->year = $fiscal_year;
            $begin_date = $start_date->format("Y-m-d");
            $end_date = $end_date->format("Y-m-d");
        } else {
            $begin_date = $start_date->format("Y-m-d");
            $end_date = $end_date->format("Y-m-d");
        }

        $number_of_years = 5;
        $years = [];
        for ($x = 0; $x <= $number_of_years; $x++) {
            $today = \Carbon\Carbon::now();
            $today->day = 1;
            $today->month = 1;
            $today->year = $fiscal_year;
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

       $board_summary = DB::select("SELECT tmp.type, SUM(tmp.pledged) as total_pledged, SUM(tmp.paid) as total_paid, SUM(tmp.participants) as total_participants, SUM(tmp.peoplenights) as total_pn, SUM(tmp.nights) as total_nights
           FROM
           (SELECT e.id as event_id, e.title as event, et.name as type, e.idnumber, e.start_date, e.end_date, DATEDIFF(e.end_date,e.start_date) as nights,
               (SELECT SUM(d.donation_amount) FROM Donations as d WHERE d.event_id=e.id) as pledged,
               (SELECT SUM(p.payment_amount) FROM Donations as d LEFT JOIN Donations_payment as p ON (p.donation_id = d.donation_id) WHERE d.event_id=e.id AND d.deleted_at IS NULL AND p.deleted_at IS NULL) as paid,
               (SELECT COUNT(*) FROM participant as reg WHERE reg.event_id = e.id AND reg.deleted_at IS NULL AND reg.canceled_at IS NULL) as participants,
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

        return view('dashboard.board', compact('years', 'fiscal_year', 'summary', 'board_summary', 'board_summary_revenue_chart', 'board_summary_participant_chart', 'board_summary_peoplenight_chart', 'total_revenue', 'total_participants', 'total_peoplenights', 'begin_date', 'end_date'));
    }
}
