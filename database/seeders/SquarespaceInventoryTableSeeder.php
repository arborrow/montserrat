<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SquarespaceInventoryTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run(): void
    {
        \DB::table('squarespace_inventory')->delete();

        \DB::table('squarespace_inventory')->insert([
            0 => [
                'id' => 1,
                'name' => 'Men\'s Retreat',
                'custom_form_id' => 2,
                'variant_options' => 2,
                'created_at' => '2022-05-02 16:00:57',
                'updated_at' => '2022-05-02 16:00:57',
                'deleted_at' => null,
            ],
            1 => [
                'id' => 2,
                'name' => 'Women\'s Retreat',
                'custom_form_id' => 2,
                'variant_options' => 2,
                'created_at' => '2022-05-02 16:01:35',
                'updated_at' => '2022-05-02 16:01:35',
                'deleted_at' => null,
            ],
            2 => [
                'id' => 3,
                'name' => 'Open Retreat (Men, Women, and Couples)',
                'custom_form_id' => 5,
                'variant_options' => 3,
                'created_at' => '2022-05-02 16:19:16',
                'updated_at' => '2022-05-21 09:27:10',
                'deleted_at' => null,
            ],
            3 => [
                'id' => 4,
                'name' => 'Retiro en Español',
                'custom_form_id' => 4,
                'variant_options' => 3,
                'created_at' => '2022-05-02 16:19:37',
                'updated_at' => '2022-05-21 10:09:59',
                'deleted_at' => null,
            ],
            4 => [
                'id' => 5,
                'name' => 'Young Adult\'s Retreat',
                'custom_form_id' => 2,
                'variant_options' => 2,
                'created_at' => '2022-05-02 16:20:04',
                'updated_at' => '2022-05-21 09:54:46',
                'deleted_at' => null,
            ],
            5 => [
                'id' => 6,
                'name' => 'Retreat Gift Certificate',
                'custom_form_id' => 7,
                'variant_options' => 1,
                'created_at' => '2022-05-02 16:20:21',
                'updated_at' => '2022-11-16 06:41:03',
                'deleted_at' => null,
            ],
            6 => [
                'id' => 7,
                'name' => 'Special Event - Man In The Ditch',
                'custom_form_id' => 6,
                'variant_options' => 0,
                'created_at' => '2022-05-02 16:21:08',
                'updated_at' => '2022-05-02 16:21:08',
                'deleted_at' => null,
            ],
            7 => [
                'id' => 8,
                'name' => 'AA Retreat',
                'custom_form_id' => 2,
                'variant_options' => 2,
                'created_at' => '2022-05-02 16:21:33',
                'updated_at' => '2022-05-02 16:21:33',
                'deleted_at' => null,
            ],
            8 => [
                'id' => 9,
                'name' => 'Couple\'s Retreat',
                'custom_form_id' => 5,
                'variant_options' => 2,
                'created_at' => '2022-05-02 16:22:58',
                'updated_at' => '2022-05-21 09:54:24',
                'deleted_at' => null,
            ],
            9 => [
                'id' => 10,
                'name' => 'Testing2',
                'custom_form_id' => 7,
                'variant_options' => null,
                'created_at' => '2022-05-02 22:59:51',
                'updated_at' => '2022-05-02 23:00:24',
                'deleted_at' => '2022-05-02 23:00:24',
            ],
        ]);
    }
}
