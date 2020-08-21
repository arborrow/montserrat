<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('locations')->delete();

        \DB::table('locations')->insert([
            0 => [
                'id' => 1,
                'name' => env('SELF_NAME'),
                'label' => env('SELF_NAME'),
                'type' => 'Site',
                'description' => 'Primary site of '.config('polanco.SELF_NAME'),
                'latitude' => '33.138498',
                'longitude' => '-97.021944',
            ],
        ]);
    }
}
