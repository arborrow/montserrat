<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('role_user')->delete();

        DB::table('role_user')->insert([
            0 => [
                'user_id' => 1,
                'role_id' => 1,
                'deleted_at' => null,
            ],
        ]);
    }
}
