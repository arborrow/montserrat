<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class DonationDescription extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */

    public ?array $middlewares = ['auth'];

    public function handler(Request $request): Chartisan
    {

      // $request->authorize('show-dashboard');
      $donation_description = (isset($request->donation_description)) ? $request->donation_description : "Retreat Funding";

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

/* // old v6 chart
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
*/

        return Chartisan::build()
            ->labels(array_keys($donors))
            ->dataset('Average', array_column($donors, 'average_amount'))
            ->dataset('Donations for '.$donation_description, array_column($donors, 'sum'));
    }
}
