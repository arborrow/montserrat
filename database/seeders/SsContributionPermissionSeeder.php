<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SsContributionPermissionSeeder extends Seeder
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

    }
}
