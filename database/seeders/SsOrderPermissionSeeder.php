<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SsOrderPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            0 => [
                'name' => 'create-squarespace-order',
                'display_name' => 'Create Squarespace Order',
                'description' => 'Create Squarespace Order',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            1 => [
                'name' => 'show-squarespace-order',
                'display_name' => 'Show Squarespace Order',
                'description' => 'Show Squarespace Order',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            2 => [
                'name' => 'update-squarespace-order',
                'display_name' => 'Update Squarespace Order',
                'description' => 'Update Squarespace Order',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            3 => [
                'name' => 'delete-squarespace-order',
                'display_name' => 'Delete Squarespace Order',
                'description' => 'Delete Squarespace Order',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);

    }
}
