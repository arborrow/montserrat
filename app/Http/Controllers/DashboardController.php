<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgcDonationsRequest;
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

    public function agc($number_of_years = 5)
    {
        $this->authorize('show-dashboard');

        $current_year = (date('m') > 6) ? date('Y') + 1 : date('Y');

        $years = [];
        $agc_descriptions = [];

        for ($x = -$number_of_years; $x <= 0; $x++) {
            $today = \Carbon\Carbon::now();
            $today->day = 1;
            $today->month = 1;
            $today->year = $current_year;
            $years[$x] = $today->addYear($x);
        }

        $donors = [];
        $agc_descriptions = \App\Models\DonationType::active()
           ->whereIn('name', config('polanco.agc_donation_descriptions'))
           ->get();

        foreach ($years as $year) {
            $label = $year->year;
            $prev_year = $year->copy()->subYear();
            // TODO: consider stepping throuh polanco.agc_donation_descriptions with a foreach to build collections - this will make this much more dynamic in the future
            $agc_donors['All'] = \App\Models\Donation::orderBy('donation_date', 'desc')
                ->whereIn('donation_description', config('polanco.agc_donation_descriptions'))
                ->where('donation_date', '>=', $prev_year->year.'-07-01')
                ->where('donation_date', '<', $year->year.'-07-01')
                ->groupBy('contact_id')->get();
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
        // dd($donors);
        return view('dashboard.agc', compact('number_of_years', 'donors', 'agc_descriptions'));
    }

    public function agc_donations(AgcDonationsRequest $request)
    {
        $this->authorize('show-donation');

        $current_year = (date('m') > 6) ? date('Y') + 1 : date('Y');
        $fiscal_year = (! isset($request->fiscal_year)) ? $current_year : $request->fiscal_year; //fiscal_year 4-digit year

        $donation_type_id = (! isset($request->donation_type_id)) ? '0' : $request->donation_type_id;
        switch ($donation_type_id) {
            case 0:
                $all_donations = \App\Models\Donation::orderBy('donation_date', 'desc')
                    ->whereIn('donation_description', config('polanco.agc_donation_descriptions'))
                    ->where('donation_date', '>=', $fiscal_year - 1 .'-07-01')
                    ->where('donation_date', '<', $fiscal_year.'-07-01')
                    ->get();
                $donations = \App\Models\Donation::orderBy('donation_date', 'desc')
                    ->whereIn('donation_description', config('polanco.agc_donation_descriptions'))
                    ->where('donation_date', '>=', $fiscal_year - 1 .'-07-01')
                    ->where('donation_date', '<', $fiscal_year.'-07-01')
                    ->paginate(25, ['*'], 'donations');
                $donations->withPath('/dashboard/agc_donations?fiscal_year='.$fiscal_year.'&donation_type_id='.$donation_type_id);

                break;
            default:
                $donation_type = \App\Models\DonationType::findOrFail($donation_type_id);
                $all_donations = \App\Models\Donation::orderBy('donation_date', 'desc')
                    ->where('donation_description', '=', $donation_type->name)
                    ->where('donation_date', '>=', $fiscal_year - 1 .'-07-01')
                    ->where('donation_date', '<', $fiscal_year.'-07-01')
                    ->get();
                $donations = \App\Models\Donation::orderBy('donation_date', 'desc')
                    ->where('donation_description', '=', $donation_type->name)
                    ->where('donation_date', '>=', $fiscal_year - 1 .'-07-01')
                    ->where('donation_date', '<', $fiscal_year.'-07-01')
                    ->paginate(25, ['*'], 'donations');
                $donations->withPath('/dashboard/agc_donations?fiscal_year='.$fiscal_year.'&donation_type_id='.$donation_type_id);
        }

        return view('donations.results', compact('donations', 'all_donations'));
    }

    public function donation_description_chart(int $category_id = null)
    {
        $this->authorize('show-dashboard');
        $descriptions = \App\Models\DonationType::active()->orderBy('name')->pluck('id', 'name');
        if (! isset($category_id)) {
            $donation_type = \App\Models\DonationType::whereName('Retreat Funding')->first();
        } else {
            $donation_type = \App\Models\DonationType::findOrFail($category_id);
        }

        return view('dashboard.description', compact('donation_type', 'descriptions'));
    }

    public function events($year = null)
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

        // TODO: using role_id = 5 as hardcoded value - explore how to use config('polanco.participant_role_id.retreatant') instead
        $event_summary = DB::select("SELECT tmp.type, tmp.type_id, SUM(tmp.pledged) as total_pledged, SUM(tmp.paid) as total_paid, SUM(tmp.participants) as total_participants, SUM(tmp.peoplenights) as total_pn, SUM(tmp.nights) as total_nights
            FROM
            (SELECT e.id as event_id, e.title as event, et.name as type, et.id as type_id, e.idnumber, e.start_date, e.end_date, DATEDIFF(e.end_date,e.start_date) as nights,
            	(SELECT SUM(d.donation_amount) FROM Donations as d WHERE d.event_id=e.id AND d.deleted_at IS NULL) as pledged,
                (SELECT SUM(p.payment_amount) FROM Donations as d LEFT JOIN Donations_payment as p ON (p.donation_id = d.donation_id) WHERE d.event_id=e.id AND d.deleted_at IS NULL AND p.deleted_at IS NULL) as paid,
                (SELECT COUNT(*) FROM participant as reg WHERE reg.event_id = e.id AND reg.deleted_at IS NULL AND reg.canceled_at IS NULL AND reg.role_id IN (5,11) AND reg.status_id IN (1)) as participants,
                (SELECT(participants*nights)) as peoplenights
                    FROM event as e LEFT JOIN event_type as et ON (et.id = e.event_type_id)
                    WHERE e.start_date > :begin_date 
                        AND e.start_date < :end_date 
                        AND e.is_active=1 
                        AND e.deleted_at IS NULL 
                        AND e.title NOT LIKE '%Deposit%' 
                        AND e.end_date < NOW()
                GROUP BY e.id) as tmp
                GROUP BY tmp.type
                ORDER BY `tmp`.`type` ASC", [
            'begin_date' => $begin_date,
            'end_date' => $end_date,
        ]);

        $total_revenue = array_sum(array_column($event_summary, 'total_paid'));
        $total_participants = array_sum(array_column($event_summary, 'total_participants'));
        $total_peoplenights = array_sum(array_column($event_summary, 'total_pn'));

        return view('dashboard.events', compact('years', 'year', 'event_summary', 'total_revenue', 'total_participants', 'total_peoplenights'));
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
        $retreats = \App\Models\Retreat::whereIsActive(1)
            ->whereEventTypeId($event_type_id)
            ->where('start_date', '>=', $begin_date)
            ->where('start_date', '<', $end_date)
            ->where('end_date', '<', now())
            ->orderBy('start_date')->get();

        return view('dashboard.drilldown', compact('event_type', 'year', 'retreats'));
    }
}
