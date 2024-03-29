<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('gender')->delete();

        DB::table('gender')->insert([
            0 => [
                'id' => 1,
                'label' => 'Male',
                'value' => 'Male',
                'name' => 'Male',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 1,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id' => 2,
                'label' => 'Female',
                'value' => 'Female',
                'name' => 'Female',
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
                'label' => 'Other',
                'value' => 'Other',
                'name' => 'Other',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => null,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
