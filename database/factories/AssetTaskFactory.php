<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetTaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\AssetTask::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start_date = Carbon::createFromTimestamp($this->faker->dateTimeBetween($startDate = '-60 days', $endDate = '-10 days')->getTimeStamp());
        $scheduled_until_date = Carbon::now()->addYear();

        return [
            'asset_id' => function () {
                return \App\Models\Asset::factory()->create()->id;
            },
            'title' => $this->faker->sentence,
            'start_date' => $start_date,
            'frequency' => $this->faker->word,
            'frequency_interval' => $this->faker->numberBetween(1,4),
            'frequency_month' => $this->faker->numberBetween(1,12),
            'frequency_day' => $this->faker->numberBetween(1,7),
            'frequency_time' => $this->faker->time(),
            'scheduled_until_date' => $scheduled_until_date,
            'description' => $this->faker->sentence,
            'priority_id' => $this->faker->numberBetween(1,5),
            'needed_labor' => $this->faker->sentence,
            'estimated_labor_cost' => $this->faker->numberBetween(0,500),
            'needed_material' => $this->faker->sentence,
            'estimated_labor_cost' => $this->faker->numberBetween(0,500),
            'vendor_id' => null,
            'category' => $this->faker->word,
            'tag' => $this->faker->word,
        ];
    }
}
