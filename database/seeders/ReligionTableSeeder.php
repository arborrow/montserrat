<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReligionTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('religion')->delete();

        DB::table('religion')->insert([
            0 => [
                'id' => 1,
                'label' => 'Catholic',
                'value' => 'Roman Catholic',
                'name' => 'Catholic',
                'is_active' => 1,
                'is_default' => 1,
                'weight' => 1,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id' => 2,
                'label' => 'Protestant',
                'value' => 'Protestant',
                'name' => 'Protestant',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 2,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'id' => 3,
                'label' => 'Mormon',
                'value' => 'Morman',
                'name' => 'Mormon',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 3,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            3 => [
                'id' => 4,
                'label' => 'Jehovah\'s Witness',
                'value' => 'Jehovah\'s Witness',
                'name' => 'Jehovah\'s Witness',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 4,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            4 => [
                'id' => 5,
                'label' => 'Jewish',
                'value' => 'Jewish',
                'name' => 'Jewish',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => null,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            5 => [
                'id' => 7,
                'label' => 'Muslim',
                'value' => 'Muslim',
                'name' => 'Muslim',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 6,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            6 => [
                'id' => 8,
                'label' => 'Buddhist',
                'value' => 'Buddhist',
                'name' => 'Buddhist',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 7,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            7 => [
                'id' => 9,
                'label' => 'Hindu',
                'value' => 'Hindu',
                'name' => 'Hindu',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 8,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            8 => [
                'id' => 10,
                'label' => 'Agnostic',
                'value' => 'Agnostic',
                'name' => 'Agnostic',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 9,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
