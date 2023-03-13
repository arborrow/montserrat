<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferralTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('referral')->delete();

        DB::table('referral')->insert([
            0 => [
                'id' => 1,
                'name' => 'Friend',
                'is_active' => 1,
                'is_default' => 1,
                'weight' => 1,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '2016-12-29 21:40:31',
                'updated_at' => '2016-12-29 21:40:31',
            ],
            1 => [
                'id' => 2,
                'name' => 'Church/Parish',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 2,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '2016-12-29 21:41:02',
                'updated_at' => '2016-12-29 21:41:02',
            ],
            2 => [
                'id' => 3,
                'name' => 'Website',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 3,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '2016-12-29 21:41:21',
                'updated_at' => '2016-12-29 21:41:21',
            ],
            3 => [
                'id' => 4,
                'name' => 'Advertisement/Publication',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 4,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '2016-12-29 21:41:46',
                'updated_at' => '2016-12-29 21:41:46',
            ],
            4 => [
                'id' => 5,
                'name' => 'Email',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 5,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '2016-12-29 21:42:03',
                'updated_at' => '2016-12-29 21:42:03',
            ],
            5 => [
                'id' => 6,
                'name' => 'Other',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 6,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '2016-12-29 21:42:36',
                'updated_at' => '2016-12-29 21:42:36',
            ],
            6 => [
                'id' => 7,
                'name' => 'Ambassador',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 7,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
