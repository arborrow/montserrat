<?php

use Illuminate\Database\Seeder;

class FileTypeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('file_type')->delete();
        
        \DB::table('file_type')->insert(array (
            0 => 
            array (
                'id' => 1,
                'label' => 'Attachment',
                'value' => 'Attachment',
                'name' => 'Attachment',
                'description' => 'Contact attachment',
                'is_default' => 1,
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
                'label' => 'Schedule',
                'value' => 'Schedule',
                'name' => 'Schedule',
                'description' => 'Retreat schedule',
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
                'label' => 'Evaluation',
                'value' => 'Evaluation',
                'name' => 'Evaluation',
                'description' => 'Retreat evaluation',
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
                'label' => 'Contract',
                'value' => 'Contract',
                'name' => 'Contract',
                'description' => 'Event contract',
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
                'label' => 'Photo',
                'value' => 'Photo',
                'name' => 'Photo',
                'description' => 'Retreat group photo',
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
                'label' => 'Avatar',
                'value' => 'Avatar',
                'name' => 'Avatar',
                'description' => 'Contact avatar',
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