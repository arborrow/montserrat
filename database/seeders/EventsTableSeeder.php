<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $retreat = \App\Models\Retreat::create([
            'title' => 'Open Deposits',
            'event_type_id' => '9',
            'idnumber' => 'opendeposits',
            'start_date' => '2019-01-01 00:00:00',
            'end_date' => '2020-01-01 00:00:00',
        ]);
    }
}
