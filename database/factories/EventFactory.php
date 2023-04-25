<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/*
 * Create generic events of various types
 * Start date will between plus or minus 60 days of today
 * End date will be 1 to 5 days after the start date
 * Title will be 2 words plus the word Retreat
 * Idnumber begins with 2018 and adds a random and unique 4 digit number
 */

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Retreat::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $start_date = Carbon::createFromTimestamp($this->faker->dateTimeBetween($startDate = '-60 days', $endDate = '+60 days')->getTimeStamp());
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date)->addDays($this->faker->numberBetween(1, 5));
        $title = ucwords(implode(' ', $this->faker->words(2))).' Retreat';
        $idnumber = (int) '2018'.$this->faker->unique()->randomNumber(4).'-'.$this->faker->unique()->lastName();
        // dd($start_date,$end_date);
        // dd($title, $start_date, $end_date, $idnumber);

        return [
            'title' => $title,
            'description' => $this->faker->sentence(),
            'event_type_id' => $this->faker->numberBetween(1, 14),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'is_active' => 1,
            'idnumber' => $idnumber,
        ];
    }
}
