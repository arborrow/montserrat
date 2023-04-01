<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationTypeTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('location_type')->delete();

        DB::table('location_type')->insert([
            0 => [
                'id' => 1,
                'name' => 'Home',
                'display_name' => 'Home',
                'vcard_name' => 'HOME',
                'description' => 'Place of residence',
                'is_reserved' => 0,
                'is_active' => 1,
                'is_default' => 1,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id' => 2,
                'name' => 'Work',
                'display_name' => 'Work',
                'vcard_name' => 'WORK',
                'description' => 'Work location',
                'is_reserved' => 0,
                'is_active' => 1,
                'is_default' => null,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'id' => 3,
                'name' => 'Main',
                'display_name' => 'Main',
                'vcard_name' => null,
                'description' => 'Main office location',
                'is_reserved' => 0,
                'is_active' => 1,
                'is_default' => null,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            3 => [
                'id' => 4,
                'name' => 'Other',
                'display_name' => 'Other',
                'vcard_name' => null,
                'description' => 'Other location',
                'is_reserved' => 0,
                'is_active' => 1,
                'is_default' => null,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            4 => [
                'id' => 5,
                'name' => 'Billing',
                'display_name' => 'Billing',
                'vcard_name' => null,
                'description' => 'Billing Address location',
                'is_reserved' => 1,
                'is_active' => 0,
                'is_default' => null,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
