<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetJobPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            0 => [
                'name' => 'create-asset-job',
                'display_name' => 'Create asset job',
                'description' => 'Create asset job',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            1 => [
                'name' => 'show-asset-job',
                'display_name' => 'Show asset job',
                'description' => 'Show asset job',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            2 => [
                'name' => 'update-asset-job',
                'display_name' => 'Update asset job',
                'description' => 'Update asset job',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            3 => [
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
