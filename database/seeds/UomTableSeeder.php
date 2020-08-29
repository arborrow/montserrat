<?php

use Illuminate\Database\Seeder;

class UomTableSeeder extends Seeder
{
    /**
     *
     * @return void
     */
    public function run()
    {
        \DB::table('uom')->delete();

        \DB::table('uom')->insert([
            0 => [
                'id' => 1,
                'unit_name' => 'Acres',
                'unit_symbol' => 'ac',
                'type' => 'Area',
                'description' => 'Acres of area',
                'is_active' => 1,
            ],
            1 => [
                'id' => 2,
                'unit_name' => 'Amps',
                'unit_symbol' => 'A',
                'type' => 'Electric current',
                'description' => 'Amps of electric current',
                'is_active' => 1,
            ],
            2 => [
                'id' => 3,
                'unit_name' => 'Cubic feet',
                'unit_symbol' => 'cu ft',
                'type' => 'Volume',
                'description' => 'Cubic feet of volume',
                'is_active' => 1,
            ],
            3 => [
                'id' => 4,
                'unit_name' => 'Days',
                'unit_symbol' => 'd',
                'type' => 'Time',
                'description' => 'Days of time',
                'is_active' => 1,
            ],
            4 => [
                'id' => 5,
                'unit_name' => 'Degrees Celcius',
                'unit_symbol' => '°C',
                'type' => 'Temperature',
                'description' => 'Degrees Celcius of temperature',
                'is_active' => 1,
            ],
            5 => [
                'id' => 6,
                'unit_name' => 'Degrees Fahrenheit',
                'unit_symbol' => '°F',
                'type' => 'Temperature',
                'description' => 'Degrees Fahrenheit of temperature',
                'is_active' => 1,
            ],
            6 => [
                'id' => 7,
                'unit_name' => 'Feet',
                'unit_symbol' => 'ft',
                'type' => 'Length',
                'description' => 'Feet of length',
                'is_active' => 1,
            ],
            7 => [
                'id' => 8,
                'unit_name' => 'Gallons',
                'unit_symbol' => 'gal',
                'type' => 'Volume',
                'description' => 'Gallons of volume',
                'is_active' => 1,
            ],
            8 => [
                'id' => 9,
                'unit_name' => 'Grams',
                'unit_symbol' => 'g',
                'type' => 'Mass',
                'description' => 'Grams of mass',
                'is_active' => 1,
            ],
            9 => [
                'id' => 10,
                'unit_name' => 'Hours',
                'unit_symbol' => 'h',
                'type' => 'Time',
                'description' => 'Hours of time',
                'is_active' => 1,
            ],
            10 => [
                'id' => 11,
                'unit_name' => 'Inches',
                'unit_symbol' => 'in',
                'type' => 'Length',
                'description' => 'Inches of length',
                'is_active' => 1,
            ],
            11 => [
                'id' => 12,
                'unit_name' => 'Kilograms',
                'unit_symbol' => 'kg',
                'type' => 'Mass',
                'description' => 'Kilograms of mass',
                'is_active' => 1,
            ],
            12 => [
                'id' => 13,
                'unit_name' => 'Minutes',
                'unit_symbol' => 'm',
                'type' => 'Time',
                'description' => 'Minutes of time',
                'is_active' => 1,
            ],
            13 => [
                'id' => 14,
                'unit_name' => 'Months',
                'unit_symbol' => 'mo',
                'type' => 'Time',
                'description' => 'Months of time',
                'is_active' => 1,
            ],
            14 => [
                'id' => 15,
                'unit_name' => 'Pounds',
                'unit_symbol' => 'lb',
                'type' => 'Mass',
                'description' => 'Pounds of mass',
                'is_active' => 1,
            ],
            15 => [
                'id' => 16,
                'unit_name' => 'Seconds',
                'unit_symbol' => 's',
                'type' => 'Time',
                'description' => 'Seconds of time',
                'is_active' => 1,
            ],
            16 => [
                'id' => 17,
                'unit_name' => 'Squarefeet',
                'unit_symbol' => 'sq',
                'type' => 'Area',
                'description' => 'Squarefeet of area',
                'is_active' => 1,
            ],
            17 => [
                'id' => 18,
                'unit_name' => 'Volts',
                'unit_symbol' => 'V',
                'type' => 'Electric current',
                'description' => 'Volts of electric current',
                'is_active' => 1,
            ],
            18 => [
                'id' => 19,
                'unit_name' => 'Years',
                'unit_symbol' => 'y',
                'type' => 'Time',
                'description' => 'Years of time',
                'is_active' => 1,
            ],
            19 => [
                'id' => 20,
                'unit_name' => 'Megabytes',
                'unit_symbol' => 'MB',
                'type' => 'Data',
                'description' => 'Megabytes of data',
                'is_active' => 1,
            ],
            20 => [
                'id' => 21,
                'unit_name' => 'Gigaytes',
                'unit_symbol' => 'GB',
                'type' => 'Data',
                'description' => 'Gigabytes of data',
                'is_active' => 1,
            ],
            21 => [
                'id' => 22,
                'unit_name' => 'Terabytes',
                'unit_symbol' => 'TB',
                'type' => 'Data',
                'description' => 'Terabytes of data',
                'is_active' => 1,
            ],
        ]);
    }
}
