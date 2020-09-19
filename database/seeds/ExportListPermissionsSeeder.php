<?php

use Illuminate\Database\Seeder;

class ExportListPermissionsSeeder extends Seeder
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
                'name' => 'create-export-list',
                'display_name' => 'Create export list',
                'description' => 'Create export list',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            1 => [
                'name' => 'show-export-list',
                'display_name' => 'Show export list',
                'description' => 'Show export list',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            2 => [
                'name' => 'update-export-list',
                'display_name' => 'Update export list',
                'description' => 'Update export list',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            3 => [
                'name' => 'delete-export-list',
                'display_name' => 'Delete export list',
                'description' => 'Delete export list',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
