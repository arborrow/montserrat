<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExportListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\ExportList::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $label = $this->faker->word;
        $type = $this->faker->randomElement(config('polanco.export_list_types'));
        $start_date = Carbon::createFromTimestamp($this->faker->dateTimeBetween($startDate = '-60 days', $endDate = '+60 days')->getTimeStamp());
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date)->addDays($this->faker->numberBetween(1, 5));

        return [
            'title' => 'Title for '.$label,
            'label' => $label,
            'type' => $type,
            'fields' => 'Fields for '.$type,
            'filters' => 'Filters for '.$type,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'last_run_date' => $this->faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now', $timezone = null),
            'end_date' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+1 year', $timezone = null),
        ];
    }
}
