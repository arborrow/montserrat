<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DonationDescription extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    use AuthorizesRequests;

    // TODO: create custom request to validate donation_description
    public function handler(Request $request): Chartisan
    {
        $this->authorize('show-dashboard');

        $descriptions = \App\Models\DonationType::active()->orderBy('name')->pluck('id', 'name');
        $category_id = (isset($request->category_id)) ? $request->category_id : 1; //hard coding default to Retreat Funding (1)
        $donation_type = \App\Models\DonationType::findOrFail($category_id);

        if (isset($donation_type)) { //validate donation_description

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
                $donations = \App\Models\Donation::whereDonationDescription($donation_type->name)
                    ->where('donation_date', '>=', $prev_year->year.'-07-01')
                    ->where('donation_date', '<', $year->year.'-07-01')
                    ->get();
                $donors[$label]['count'] = $donations->count();
                $donors[$label]['sum'] = $donations->sum('donation_amount');
            }
            $average_amount = ((((array_sum(array_column($donors, 'sum'))) - ($donors[$current_year]['sum'])) / ($number_of_years)));

            foreach ($years as $year) {
                $label = $year->year;
                $prev_year = $year->copy()->subYear();
                $donors[$label]['average_amount'] = $average_amount;
            }

            return Chartisan::build()
                ->labels(array_keys($donors))
                ->dataset('Average', array_column($donors, 'average_amount'))
                ->dataset('Donations for '.$donation_type->name, array_column($donors, 'sum'));
        } else {
          return Chartisan::build();
        }
    }
}
