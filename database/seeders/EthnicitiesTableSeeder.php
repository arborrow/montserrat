<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EthnicitiesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('ethnicities')->delete();

        DB::table('ethnicities')->insert([
            0 => [
                'id' => 1,
                'ethnicity' => 'Unspecified',
                'description' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
            1 => [
                'id' => 2,
                'ethnicity' => 'Asian',
                'description' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
            2 => [
                'id' => 3,
                'ethnicity' => 'Black',
                'description' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
            3 => [
                'id' => 4,
                'ethnicity' => 'Native',
                'description' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
            4 => [
                'id' => 5,
                'ethnicity' => 'Pacific',
                'description' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
            5 => [
                'id' => 6,
                'ethnicity' => 'White',
                'description' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
            6 => [
                'id' => 7,
                'ethnicity' => 'Hispanic',
                'description' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
            7 => [
                'id' => 8,
                'ethnicity' => 'Other',
                'description' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
        ]);
    }
}
