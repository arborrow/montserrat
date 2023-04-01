<?php

declare(strict_types=1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AgcAmount extends BaseChart
{
    use AuthorizesRequests;

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */

    // TODO: create custom request to validate number_of_years
    public function handler(Request $request): Chartisan
    {
        $number_of_years = (isset($request->number_of_years)) ? $request->number_of_years : 5;

        // polanco.cool_colors defines 9 different colors that can be used in generating charts, I take mod 8 to rotate through the first 8 colors and then repeat
        // TODO: get % of returning or % of last year but unfortunately not this year  between agc years
        $this->authorize('show-dashboard');
        $current_year = (date('m') > 6) ? date('Y') + 1 : date('Y');

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

        $agc_amount_chart = Chartisan::build()
            ->labels(array_keys($donors))
            ->dataset('Total Average', array_column($donors, 'average_amount'))
            ->dataset('Total Donations per Year', array_column($donors, 'sum'));

        foreach (config('polanco.agc_donation_descriptions') as $key => $description) {
            $agc_amount_chart->dataset($description, array_column($donors, 'sum_'.$description));
        }

        return $agc_amount_chart;
    }
}
