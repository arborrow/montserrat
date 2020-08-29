<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Asset::class, function (Faker $faker) {
    $start_date = Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '-60 days', $endDate = '-10 days')->getTimeStamp());
    $asset = $faker->word;
    $power_uom = factory(App\Uom::class)->create([
        'type' => 'Electric current',
    ]);
    $length_uom = factory(App\Uom::class)->create([
        'type' => 'Length',
    ]);
    $weight_uom = factory(App\Uom::class)->create([
        'type' => 'Mass',
    ]);
    $time_uom = factory(App\Uom::class)->create([
        'type' => 'Time',
    ]);


    return [
        'name' => $asset,
        'asset_type_id' => function () {
            return factory(App\AssetType::class)->create()->id;
        },
        'description' => $faker->sentence,

        'manufacturer' => $faker->company,
        'model' => $faker->md5,
        'serial_number' => $faker->isbn10,
        'year' => $faker->year,
        'location_id' => function () {
            return factory(App\Location::class)->create()->id;
        },
        'department_id' => null,
        'parent_id' => null,
        'status' => $faker->word,
        'remarks' => $faker->sentence,
        'is_active' => $faker->boolean,
        'manufacturer_id' => function () {
            return factory(App\Contact::class)->create([
                'organization_name' => $this->faker->company,
                'contact_type' => config('polanco.contact_type.organization'),
                'subcontact_type' => config('polanco.contact_type.vendor')
                ])->id;
        },
        'vendor_id' => function () {
            return factory(App\Contact::class)->create([
                'organization_name' => $this->faker->company,
                'contact_type' => config('polanco.contact_type.organization'),
                'subcontact_type' => config('polanco.contact_type.vendor')
                ])->id;
        },
        'power_line_voltage' => $faker->numberBetween(120,240),
        'power_line_voltage_uom_id' => $power_uom->id,
        'power_phase_voltage' => $faker->numberBetween(120,240),
        'power_phase_voltage_uom_id' => $power_uom->id,
        'power_phases' => $faker->numberBetween(1,5),
        'power_amp' => $faker->numberBetween(10,50),
        'power_amp_uom_id' => $power_uom->id,
        'length' => $faker->numberBetween(10,30),
        'length_uom_id' => $length_uom->id,
        'width' => $faker->numberBetween(10,25),
        'width_uom_id' => $length_uom->id,
        'height' => $faker->numberBetween(10,20),
        'height_uom_id' => $length_uom->id,
        'weight' => $faker->numberBetween(50,150),
        'weight_uom_id' => $weight_uom->id,
        'capacity' => $faker->numberBetween(500,1000),
        'capacity_uom_id' => $weight_uom->id,
        'purchase_date' => $faker->date,
        'purchase_price' => $faker->randomFloat(2,100,1000),
        'life_expectancy' => $faker->numberBetween(1,10),
        'life_expectancy_uom_id' => $time_uom->id,
        'start_date' => $start_date,
        'end_date' => NULL,
        'replacement_id' => NULL,
        'warranty_start_date' => $start_date,
        'warranty_end_date' => NULL,
        'depreciation_start_date' => $start_date,
        'depreciation_end_date' => NULL,
        'depreciation_type_id' => NULL,
        'depreciation_rate' => NULL,
        'depreciation_value' => NULL,
        'depreciation_time' => $faker->numberBetween(5,10),
        'depreciation_time_uom_id' => $time_uom->id,
    ];
});
