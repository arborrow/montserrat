<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('departments')->delete();

        \DB::table('departments')->insert([
            0 => [
                'name' => 'Administration',
                'label' => 'Admin',
                'description' => 'Administration',
                'parent_id' => null,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            1 => [
                'name' => 'Kitchen',
                'label' => 'Kitchen',
                'description' => 'Kitchen',
                'parent_id' => null,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            2 => [
                'name' => 'Housekeeping',
                'label' => 'Housekeeping',
                'description' => 'Housekeeping',
                'parent_id' => null,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            3 => [
                'name' => 'Maintenance',
                'label' => 'Maint',
                'description' => 'Maintenance',
                'parent_id' => null,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            4 => [
                'name' => 'Jesuits',
                'label' => 'Jesuits',
                'description' => 'Jesuits',
                'parent_id' => null,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
