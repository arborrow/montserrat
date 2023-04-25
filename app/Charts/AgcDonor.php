<?php

declare(strict_types=1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AgcDonor extends BaseChart
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
        $colors = [];
        $this->authorize('show-dashboard');
        $current_year = (date('m') > 6) ? date('Y') + 1 : date('Y');
        $number_of_years = (isset($request->number_of_years)) ? $request->number_of_years : 5;

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

            //unique donors
            $donors[$label]['count'] = $agc_donors['All']->count();
            foreach (config('polanco.agc_donation_descriptions') as $description) {
                $donors[$label]['count_'.$description] = $agc_donors[$description]->count();
            }
        }
        $average_donor_count = (((array_sum(array_column($donors, 'count'))) - ($donors[$current_year]['count'])) / (count(array_column($donors, 'count')) - 1));

        foreach ($years as $year) {
            $label = $year->year;
            $prev_year = $year->copy()->subYear();
            $donors[$label]['average_count'] = $average_donor_count;
        }

        /*
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

        */

        $agc_donor_chart = Chartisan::build()
            ->labels(array_keys($donors))
            ->dataset('Total Average', array_column($donors, 'average_count'))
            ->dataset('Total Donors per Year', array_column($donors, 'count'));
        array_push($colors, 'rgba(22,160,133, 1.0)');

        foreach (config('polanco.agc_donation_descriptions') as $key => $description) {
            $agc_donor_chart->dataset($description, array_column($donors, 'count_'.$description));
            array_push($colors, 'rgba('.config('polanco.agc_cool_colors')[$key % 8].', 0.8)');
        }

        $agc_donor_chart->colors = $colors;
        // dd($agc_donor_chart);

        return $agc_donor_chart;
    }
}
