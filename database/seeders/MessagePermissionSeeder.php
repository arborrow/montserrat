<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessagePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    // admin-mailgun, show-mailgun, update-mailgun
    public function run()
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
            4 => [
                'name' => 'admin-mailgun',
                'display_name' => 'Administer mailgun',
                'description' => 'Administer mailgun',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
