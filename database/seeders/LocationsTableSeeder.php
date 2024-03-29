<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->insert([
            0 => [
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
