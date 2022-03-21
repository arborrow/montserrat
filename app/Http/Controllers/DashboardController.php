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
    {
        $this->authorize('show-dashboard');
        return view('dashboard.agc');
    }

    public function donation_description_chart($donation_description = 'Retreat Funding')
    {
      $this->authorize('show-dashboard');
      $descriptions = \App\Models\DonationType::active()->orderBy('name')->pluck('name', 'name');

      return view('dashboard.description',compact('donation_description','descriptions'));
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
        $board_summary = DB::select("SELECT tmp.type, tmp.type_id, SUM(tmp.pledged) as total_pledged, SUM(tmp.paid) as total_paid, SUM(tmp.participants) as total_participants, SUM(tmp.peoplenights) as total_pn, SUM(tmp.nights) as total_nights
            FROM
            (SELECT e.id as event_id, e.title as event, et.name as type, et.id as type_id, e.idnumber, e.start_date, e.end_date, DATEDIFF(e.end_date,e.start_date) as nights,
            	(SELECT SUM(d.donation_amount) FROM Donations as d WHERE d.event_id=e.id AND d.deleted_at IS NULL) as pledged,
            	(SELECT SUM(p.payment_amount) FROM Donations as d LEFT JOIN Donations_payment as p ON (p.donation_id = d.donation_id) WHERE d.event_id=e.id AND d.deleted_at IS NULL AND p.deleted_at IS NULL) as paid,
            	(SELECT COUNT(*) FROM participant as reg WHERE reg.event_id = e.id AND reg.deleted_at IS NULL AND reg.canceled_at IS NULL AND reg.role_id IN (5,11) AND reg.status_id IN (1)) as participants,
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

    public function drilldown($event_type_id = null, $year = null)
    {

        // default to current fiscal year
        if (! isset($year)) {
            $year = (date('m') > 6) ? date('Y') + 1 : date('Y');
        }

        $current_year = (date('m') > 6) ? date('Y') + 1 : date('Y');
        $prev_year = $year - 1;
        $begin_date = $prev_year.'-07-01';
        $end_date = $year.'-07-01';
        $event_type = \App\Models\EventType::findOrFail($event_type_id);
        $retreats = \App\Models\Retreat::whereIsActive(1)->whereEventTypeId($event_type_id)->where('start_date', '>=', $begin_date)->where('start_date', '<', $end_date)->orderBy('start_date')->get();

        return view('dashboard.drilldown', compact('event_type', 'year', 'retreats'));
    }
}
