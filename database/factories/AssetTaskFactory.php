<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $start_date = Carbon::createFromTimestamp($this->faker->dateTimeBetween($startDate = '-60 days', $endDate = '-10 days')->getTimeStamp());
        $scheduled_until_date = Carbon::now()->addYear();

        return [
            'asset_id' => function () {
                return \App\Models\Asset::factory()->create()->id;
            },
            'title' => $this->faker->sentence(),
            'start_date' => $start_date,
            'frequency' => $this->faker->randomElement(config('polanco.asset_task_frequency')),
            'frequency_interval' => $this->faker->numberBetween(1, 4),
            'frequency_month' => $this->faker->numberBetween(1, 12),
            'frequency_day' => $this->faker->numberBetween(1, 7),
            'frequency_time' => $this->faker->time(),
            'scheduled_until_date' => $scheduled_until_date,
            'description' => $this->faker->sentence(),
            'priority_id' => $this->faker->randomElement(config('polanco.priority')),
            'needed_labor_minutes' => $this->faker->numberBetween(5, 120),
            'estimated_labor_cost' => number_format($this->faker->numberBetween(0, 500), 2),
            'needed_material' => $this->faker->sentence(),
            'estimated_material_cost' => number_format($this->faker->numberBetween(0, 500), 2),
            'vendor_id' => null,
            'category' => $this->faker->word(),
            'tag' => $this->faker->word(),
        ];
    }
}
