<?php

use Illuminate\Database\Seeder;

class EthnicitiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ethnicities')->delete();
        
        \DB::table('ethnicities')->insert(array (
            0 => 
            array (
                'id' => 1,
                'ethnicity' => 'Unspecified',
                'description' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'ethnicity' => 'Asian',
                'description' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            2 => 
            array (
                'id' => 3,
                'ethnicity' => 'Black',
                'description' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            3 => 
            array (
                'id' => 4,
                'ethnicity' => 'Native',
                'description' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            4 => 
            array (
                'id' => 5,
                'ethnicity' => 'Pacific',
                'description' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            5 => 
            array (
                'id' => 6,
                'ethnicity' => 'White',
                'description' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            6 => 
            array (
                'id' => 7,
                'ethnicity' => 'Hispanic',
                'description' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            7 => 
            array (
                'id' => 8,
                'ethnicity' => 'Other',
                'description' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
        ));
        
        
    }
}