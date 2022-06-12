<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SsInventoryPermissionSeeder extends Seeder
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
                'name' => 'create-squarespace-inventory',
                'display_name' => 'Create Squarespace Inventory',
                'description' => 'Create Squarespace Inventory',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            1 => [
                'name' => 'show-squarespace-inventory',
                'display_name' => 'Show Squarespace Inventory',
                'description' => 'Show Squarespace Inventory',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            2 => [
                'name' => 'update-squarespace-inventory',
                'display_name' => 'Update Squarespace Inventory',
                'description' => 'Update Squarespace Inventory',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            3 => [
                'name' => 'delete-squarespace-inventory',
                'display_name' => 'Delete Squarespace Inventory',
                'description' => 'Delete Squarespace Inventory',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);

    }
}
