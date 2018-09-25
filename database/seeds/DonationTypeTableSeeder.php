<?php

use Illuminate\Database\Seeder;

class DonationTypeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('donation_type')->delete();
        
        \DB::table('donation_type')->insert(array (
            0 => 
            array (
                'id' => 1,
                'label' => 'Retreat Offering',
                'value' => '1',
                'name' => 'Retreat Offering',
                'description' => 'Retreat Offering',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 11,
                'label' => 'Books',
                'value' => '11',
                'name' => 'Books',
                'description' => 'Books',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 24,
                'label' => 'Miscellaneous',
                'value' => '25',
                'name' => 'Miscellaneous',
                'description' => 'Miscellaneous',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 107,
                'label' => 'Day Only Events',
                'value' => '111',
                'name' => 'Day Only Events',
                'description' => 'Day Only Events',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 115,
                'label' => 'Deposit',
                'value' => '119',
                'name' => 'Deposit',
                'description' => 'Deposit',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}