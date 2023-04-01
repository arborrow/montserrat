<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SquarespacePermissionsSeeder extends Seeder
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
                'name' => 'create-squarespace-contribution',
                'display_name' => 'Create Squarespace Contribution',
                'description' => 'Create Squarespace Contribution',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            1 => [
                'name' => 'show-squarespace-contribution',
                'display_name' => 'Show Squarespace Contribution',
                'description' => 'Show Squarespace Contribution',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            2 => [
                'name' => 'update-squarespace-contribution',
                'display_name' => 'Update Squarespace Contribution',
                'description' => 'Update Squarespace Contribution',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            3 => [
                'name' => 'delete-squarespace-contribution',
                'display_name' => 'Delete Squarespace Contribution',
                'description' => 'Delete Squarespace Contribution',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);

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

        DB::table('permissions')->insert([
            0 => [
                'name' => 'create-squarespace-custom-form',
                'display_name' => 'Create Squarespace Custom Form',
                'description' => 'Create Squarespace Custom Form',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            1 => [
                'name' => 'show-squarespace-custom-form',
                'display_name' => 'Show Squarespace Custom Form',
                'description' => 'Show Squarespace Custom Form',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            2 => [
                'name' => 'update-squarespace-custom-form',
                'display_name' => 'Update Squarespace Custom Form',
                'description' => 'Update Squarespace Custom Form',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            3 => [
                'name' => 'delete-squarespace-custom-form',
                'display_name' => 'Delete Squarespace Custom Form',
                'description' => 'Delete Squarespace Custom Form',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);

        DB::table('permissions')->insert([
            0 => [
                'name' => 'create-squarespace-custom-form-field',
                'display_name' => 'Create Squarespace Custom Form Field',
                'description' => 'Create Squarespace Custom Form Field',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            1 => [
                'name' => 'show-squarespace-custom-form-field',
                'display_name' => 'Show Squarespace Custom Form Field',
                'description' => 'Show Squarespace Custom Form Field',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            2 => [
                'name' => 'update-squarespace-custom-form-field',
                'display_name' => 'Update Squarespace Custom Form Field',
                'description' => 'Update Squarespace Custom Form Field',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            3 => [
                'name' => 'delete-squarespace-custom-form-field',
                'display_name' => 'Delete Squarespace Custom Form Field',
                'description' => 'Delete Squarespace Custom Form Field',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
