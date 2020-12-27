<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetPermissionsSeeder extends Seeder
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
                'name' => 'create-asset',
                'display_name' => 'Create asset',
                'description' => 'Create asset',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            1 => [
                'name' => 'show-asset',
                'display_name' => 'Show asset',
                'description' => 'Show asset',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            2 => [
                'name' => 'update-asset',
                'display_name' => 'Update asset',
                'description' => 'Update asset',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            3 => [
                'name' => 'delete-asset',
                'display_name' => 'Delete asset',
                'description' => 'Delete asset',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            4 => [
                'name' => 'create-asset-task',
                'display_name' => 'Create asset task',
                'description' => 'Create asset task',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            5 => [
                'name' => 'show-asset-task',
                'display_name' => 'Show asset task',
                'description' => 'Show asset task',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            6 => [
                'name' => 'update-asset-task',
                'display_name' => 'Update asset task',
                'description' => 'Update asset task',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            7 => [
                'name' => 'delete-asset-task',
                'display_name' => 'Delete asset task',
                'description' => 'Delete asset task',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            8 => [
                'name' => 'create-asset-job',
                'display_name' => 'Create asset job',
                'description' => 'Create asset job',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            9 => [
                'name' => 'show-asset-job',
                'display_name' => 'Show asset job',
                'description' => 'Show asset job',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            10 => [
                'name' => 'update-asset-job',
                'display_name' => 'Update asset job',
                'description' => 'Update asset job',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            11 => [
                'name' => 'delete-asset-job',
                'display_name' => 'Delete asset job',
                'description' => 'Delete asset job',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                ],
        ]);
    }
}
