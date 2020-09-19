<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuditPermissionsSeeder extends Seeder
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
                'name' => 'create-audit',
                'display_name' => 'Create audit',
                'description' => 'Create audit',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            1 => [
                'name' => 'show-audit',
                'display_name' => 'Show audit',
                'description' => 'Show audit',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            2 => [
                'name' => 'update-audit',
                'display_name' => 'Update audit',
                'description' => 'Update audit',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            3 => [
                'name' => 'delete-audit',
                'display_name' => 'Delete audit',
                'description' => 'Delete audit',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
