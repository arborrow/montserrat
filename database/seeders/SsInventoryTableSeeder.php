<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SsInventoryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ss_inventory')->delete();
        
        \DB::table('ss_inventory')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Men\'s Retreat',
                'custom_form_id' => 2,
                'variant_options' => 2,
                'created_at' => '2022-05-02 16:00:57',
                'updated_at' => '2022-05-02 16:00:57',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Women\'s Retreat',
                'custom_form_id' => 2,
                'variant_options' => 2,
                'created_at' => '2022-05-02 16:01:35',
                'updated_at' => '2022-05-02 16:01:35',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
            'name' => 'Open Retreat (Men, Women, and Couples)',
                'custom_form_id' => 5,
                'variant_options' => 3,
                'created_at' => '2022-05-02 16:19:16',
                'updated_at' => '2022-05-21 09:27:10',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Retiro en Español',
                'custom_form_id' => 4,
                'variant_options' => 3,
                'created_at' => '2022-05-02 16:19:37',
                'updated_at' => '2022-05-21 10:09:59',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Young Adult\'s Retreat',
                'custom_form_id' => 2,
                'variant_options' => 2,
                'created_at' => '2022-05-02 16:20:04',
                'updated_at' => '2022-05-21 09:54:46',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Retreat Gift Certificates',
                'custom_form_id' => 7,
                'variant_options' => 0,
                'created_at' => '2022-05-02 16:20:21',
                'updated_at' => '2022-05-02 16:20:21',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Special Event - Man In The Ditch',
                'custom_form_id' => 6,
                'variant_options' => 0,
                'created_at' => '2022-05-02 16:21:08',
                'updated_at' => '2022-05-02 16:21:08',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'AA Retreat',
                'custom_form_id' => 2,
                'variant_options' => 2,
                'created_at' => '2022-05-02 16:21:33',
                'updated_at' => '2022-05-02 16:21:33',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Couple\'s Retreat',
                'custom_form_id' => 5,
                'variant_options' => 2,
                'created_at' => '2022-05-02 16:22:58',
                'updated_at' => '2022-05-21 09:54:24',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Testing2',
                'custom_form_id' => 7,
                'variant_options' => NULL,
                'created_at' => '2022-05-02 22:59:51',
                'updated_at' => '2022-05-02 23:00:24',
                'deleted_at' => '2022-05-02 23:00:24',
            ),
        ));
        
        
    }
}