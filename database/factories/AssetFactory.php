<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Asset::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start_date = Carbon::createFromTimestamp($this->faker->dateTimeBetween($startDate = '-60 days', $endDate = '-10 days')->getTimeStamp());
        $asset = $this->faker->word;
        $power_uom = \App\Models\Uom::factory()->create([
            'type' => 'Electric current',
        ]);
        $length_uom = \App\Models\Uom::factory()->create([
            'type' => 'Length',
        ]);
        $weight_uom = \App\Models\Uom::factory()->create([
            'type' => 'Mass',
        ]);
        $time_uom = \App\Models\Uom::factory()->create([
            'type' => 'Time',
        ]);

        return [
            'name' => $asset,
            'asset_type_id' => function () {
                return \App\Models\AssetType::factory()->create()->id;
            },
            'description' => $this->faker->sentence,

            'manufacturer' => $this->faker->company,
            'model' => $this->faker->md5,
            'serial_number' => $this->faker->isbn10,
            'year' => $this->faker->year,
            'location_id' => function () {
                return \App\Models\Location::factory()->create()->id;
            },
            'department_id' => null,
            'parent_id' => null,
            'status' => $this->faker->word,
            'remarks' => $this->faker->sentence,
            'is_active' => $this->faker->boolean,
            'manufacturer_id' => function () {
                return \App\Models\Contact::factory()->create([
                    'organization_name' => $this->faker->company,
                    'contact_type' => config('polanco.contact_type.organization'),
                    'subcontact_type' => config('polanco.contact_type.vendor'),
                ])->id;
            },
            'vendor_id' => function () {
                return \App\Models\Contact::factory()->create([
                    'organization_name' => $this->faker->company,
                    'contact_type' => config('polanco.contact_type.organization'),
                    'subcontact_type' => config('polanco.contact_type.vendor'),
                ])->id;
            },
            'power_line_voltage' => $this->faker->numberBetween(120, 240),
            'power_line_voltage_uom_id' => $power_uom->id,
            'power_phase_voltage' => $this->faker->numberBetween(120, 240),
            'power_phase_voltage_uom_id' => $power_uom->id,
            'power_phases' => $this->faker->numberBetween(1, 5),
            'power_amp' => $this->faker->numberBetween(10, 50),
            'power_amp_uom_id' => $power_uom->id,
            'length' => $this->faker->numberBetween(10, 30),
            'length_uom_id' => $length_uom->id,
            'width' => $this->faker->numberBetween(10, 25),
            'width_uom_id' => $length_uom->id,
            'height' => $this->faker->numberBetween(10, 20),
            'height_uom_id' => $length_uom->id,
            'weight' => $this->faker->numberBetween(50, 150),
            'weight_uom_id' => $weight_uom->id,
            'capacity' => $this->faker->numberBetween(500, 1000),
            'capacity_uom_id' => $weight_uom->id,
            'purchase_date' => $this->faker->date,
            'purchase_price' => $this->faker->randomFloat(2, 100, 1000),
            'life_expectancy' => $this->faker->numberBetween(1, 10),
            'life_expectancy_uom_id' => $time_uom->id,
            'start_date' => $start_date,
            'end_date' => null,
            'replacement_id' => null,
            'warranty_start_date' => $start_date,
            'warranty_end_date' => null,
            'depreciation_start_date' => $start_date,
            'depreciation_end_date' => null,
            'depreciation_type_id' => null,
            'depreciation_rate' => null,
            'depreciation_value' => null,
            'depreciation_time' => $this->faker->numberBetween(5, 10),
            'depreciation_time_uom_id' => $time_uom->id,
        ];
    }
}
