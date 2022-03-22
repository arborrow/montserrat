<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;


class EventPeoplenights extends BaseChart
{
    use AuthorizesRequests;

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        // TODO: Create donut chart for average number of retreatants per event (get count of event_type_id) partipants/count(event_type_id) //useful for Ambassador goal of 40 (draw goal line)
        $this->authorize('show-dashboard');

        $year = (isset($request->year)) ? $request->year : NULL;

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

        return Chartisan::build()
            ->labels(array_column($board_summary, 'type'))
            ->dataset('FY People Nights by Event Type', array_column($board_summary, 'total_pn'));
    }
}
