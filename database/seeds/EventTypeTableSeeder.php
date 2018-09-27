<?php

use Illuminate\Database\Seeder;

class EventTypeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('event_type')->delete();
        
        \DB::table('event_type')->insert(array (
            0 => 
            array (
                'id' => 1,
                'label' => 'Conference',
                'value' => 'Conference',
                'name' => 'Conference',
                'description' => 'Conference',
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
                'id' => 2,
                'label' => 'Exhibition',
                'value' => 'Exhibition',
                'name' => 'Exhibition',
                'description' => 'Exhibition',
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
                'id' => 3,
                'label' => 'Fundraiser',
                'value' => 'Fundraiser',
                'name' => 'Fundraiser',
                'description' => 'Fundraiser',
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
                'id' => 4,
                'label' => 'Meeting',
                'value' => 'Meeting',
                'name' => 'Meeting',
                'description' => 'Meeting',
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
                'id' => 5,
                'label' => 'Performance',
                'value' => 'Performance',
                'name' => 'Performance',
                'description' => 'Performance',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'label' => 'Workshop',
                'value' => 'Workshop',
                'name' => 'Workshop',
                'description' => 'Workshop',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'label' => 'Ignatian',
                'value' => 'Ignatian',
                'name' => 'Ignatian',
                'description' => 'Ignatian Retreat',
                'is_default' => 1,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'label' => 'Diocesan',
                'value' => 'Diocesan',
                'name' => 'Diocesan',
                'description' => 'Diocesan',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'label' => 'Other',
                'value' => 'Other',
                'name' => 'Other',
                'description' => 'Other',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'label' => 'Day',
                'value' => 'Day',
                'name' => 'Day',
                'description' => 'Day',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'label' => 'Contract',
                'value' => 'Contract',
                'name' => 'Contract',
                'description' => 'Contract',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'label' => 'Directed',
                'value' => 'Directed',
                'name' => 'Directed',
                'description' => 'Directed',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'label' => 'ISI',
                'value' => 'ISI',
                'name' => 'ISI',
                'description' => 'Events related to ISI',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'label' => 'Jesuit',
                'value' => 'Jesuit',
                'name' => 'Jesuit',
            'description' => 'Events sponsored by the Jesuits (Assistancy, Province, or other Jesuit ministry)',
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