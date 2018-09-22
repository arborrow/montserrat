<?php

use Illuminate\Database\Seeder;

class GenderTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('gender')->delete();
        
        \DB::table('gender')->insert(array (
            0 => 
            array (
                'id' => 1,
                'label' => 'Male',
                'value' => 'Male',
                'name' => 'Male',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'label' => 'Female',
                'value' => 'Female',
                'name' => 'Female',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 2,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'label' => 'Other',
                'value' => 'Other',
                'name' => 'Other',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => NULL,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}