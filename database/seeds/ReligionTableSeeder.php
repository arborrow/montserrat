<?php

use Illuminate\Database\Seeder;

class ReligionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('religion')->delete();
        
        \DB::table('religion')->insert(array (
            0 => 
            array (
                'id' => 1,
                'label' => 'Catholic',
                'value' => 'Roman Catholic',
                'name' => 'Catholic',
                'is_active' => 1,
                'is_default' => 1,
                'weight' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'label' => 'Protestant',
                'value' => 'Protestant',
                'name' => 'Protestant',
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
                'label' => 'Mormon',
                'value' => 'Morman',
                'name' => 'Mormon',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 3,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'label' => 'Jehovah\'s Witness',
                'value' => 'Jehovah\'s Witness',
                'name' => 'Jehovah\'s Witness',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 4,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'label' => 'Jewish',
                'value' => 'Jewish',
                'name' => 'Jewish',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => NULL,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 7,
                'label' => 'Muslim',
                'value' => 'Muslim',
                'name' => 'Muslim',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 6,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 8,
                'label' => 'Buddhist',
                'value' => 'Buddhist',
                'name' => 'Buddhist',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 7,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 9,
                'label' => 'Hindu',
                'value' => 'Hindu',
                'name' => 'Hindu',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 8,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 10,
                'label' => 'Agnostic',
                'value' => 'Agnostic',
                'name' => 'Agnostic',
                'is_active' => 1,
                'is_default' => 0,
                'weight' => 9,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}