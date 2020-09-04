<?php

use Illuminate\Database\Seeder;

class SnippetPermissionsSeeder extends Seeder
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
                'name' => 'create-snippet',
                'display_name' => 'Create snippet',
                'description' => 'Create snippet',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            1 => [
                'name' => 'show-snippet',
                'display_name' => 'Show snippet',
                'description' => 'Show snippet',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            2 => [
                'name' => 'update-snippet',
                'display_name' => 'Update snippet',
                'description' => 'Update snippet',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            3 => [
                'name' => 'delete-snippet',
                'display_name' => 'Delete snippet',
                'description' => 'Delete snippet',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
