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
    public function run(): void
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
        ]);
    }
}
