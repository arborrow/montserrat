<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TouchcategoriesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('touchcategories')->delete();

        \DB::table('touchcategories')->insert([
            0 => [
                'id' => 1,
                'name' => 'Retreat',
                'description' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
            1 => [
                'id' => 2,
                'name' => 'Fundraising',
                'description' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
            2 => [
                'id' => 3,
                'name' => 'Spirituality',
                'description' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
            3 => [
                'id' => 4,
                'name' => 'Vendor',
                'description' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
            4 => [
                'id' => 5,
                'name' => 'Ambassador',
                'description' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
            5 => [
                'id' => 6,
                'name' => 'General',
                'description' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
            6 => [
                'id' => 7,
                'name' => 'Volunteer',
                'description' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
            7 => [
                'id' => 8,
                'name' => 'Prayer',
                'description' => 'Mass intentions and prayer requests',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
        ]);
    }
}
