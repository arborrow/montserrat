<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessagePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    // admin-mailgun, show-mailgun, update-mailgun
    public function run(): void
    {
        DB::table('permissions')->insert([
            0 => [
                'name' => 'create-mailgun',
                'display_name' => 'Create mailgun',
                'description' => 'Create mailgun',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            1 => [
                'name' => 'show-mailgun',
                'display_name' => 'Show mailgun',
                'description' => 'Show mailgun',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            2 => [
                'name' => 'update-mailgun',
                'display_name' => 'Update mailgun',
                'description' => 'Update mailgun',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            3 => [
                'name' => 'delete-mailgun',
                'display_name' => 'Delete mailgun',
                'description' => 'Delete mailgun',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
