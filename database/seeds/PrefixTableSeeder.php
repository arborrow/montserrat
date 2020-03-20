<?php

use Illuminate\Database\Seeder;

class PrefixTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('prefix')->delete();

        \DB::table('prefix')->insert([
            0 => [
                'id' => 1,
                'name' => 'Mrs.',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id' => 2,
                'name' => 'Ms.',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'id' => 3,
                'name' => 'Mr.',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            3 => [
                'id' => 4,
                'name' => 'Dr.',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            4 => [
                'id' => 5,
                'name' => 'Rev.',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            5 => [
                'id' => 6,
                'name' => 'Fr.',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            6 => [
                'id' => 7,
                'name' => 'Sr.',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            7 => [
                'id' => 8,
                'name' => 'Br.',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            8 => [
                'id' => 9,
                'name' => 'Most Rev.',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            9 => [
                'id' => 10,
                'name' => 'Msgr.',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            10 => [
                'id' => 11,
                'name' => 'Deacon',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
