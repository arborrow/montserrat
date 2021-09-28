<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetJobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\AssetJob::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   // start and end dates are NULL for the factory so assuming that no job has been completed
        $start_date = Carbon::createFromTimestamp($this->faker->dateTimeBetween($startDate = '+30 days', $endDate = '+90 days')->getTimeStamp());
        $staff = \App\Models\Contact::factory()->create();

        return [

            'asset_task_id' => function () {
                return \App\Models\AssetTask::factory()->create()->id;
            },
            'assigned_to_id' => function() {
                return \App\Models\Contact::factory()->create()->id;
            },
            'scheduled_date' => $start_date,
            'start_date' => NULL,
            'end_date' => NULL,
            'status' => $this->faker->randomElement(config('polanco.asset_job_status')),
            'additional_materials' => $this->faker->sentence(),
            'actual_labor' => $this->faker->numberBetween(15,60),
            'actual_labor_cost' => number_format($this->faker->numberBetween(0,500),2),
            'actual_material_cost' => number_format($this->faker->numberBetween(0,500),2),
            'note' => $this->faker->sentence(),
            'tag' => $this->faker->word(),
        ];
    }
}
