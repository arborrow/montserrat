<?php

use Illuminate\Database\Seeder;

class DepartmentPermissionsSeeder extends Seeder
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
                'name' => 'create-department',
                'display_name' => 'Create department',
                'description' => 'Create department',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            1 => [
                'name' => 'show-department',
                'display_name' => 'Show department',
                'description' => 'Show department',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            2 => [
                'name' => 'update-department',
                'display_name' => 'Update department',
                'description' => 'Update department',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            3 => [
                'name' => 'delete-department',
                'display_name' => 'Delete department',
                'description' => 'Delete department',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
