<?php

use Illuminate\Database\Seeder;

class ContactTypeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('contact_type')->delete();
        
        \DB::table('contact_type')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Individual',
                'label' => 'Individual',
                'description' => NULL,
                'image_URL' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'is_reserved' => 1,
                'status' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Household',
                'label' => 'Household',
                'description' => NULL,
                'image_URL' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'is_reserved' => 1,
                'status' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Organization',
                'label' => 'Organization',
                'description' => NULL,
                'image_URL' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'is_reserved' => 1,
                'status' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Parish',
                'label' => 'Parish',
                'description' => NULL,
                'image_URL' => NULL,
                'parent_id' => 5,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Diocese',
                'label' => 'Diocese',
                'description' => NULL,
                'image_URL' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Province',
                'label' => 'Province',
                'description' => 'Jesuit Province',
                'image_URL' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Community',
                'label' => 'Jesuit Community',
                'description' => 'Jesuit Community',
                'image_URL' => NULL,
                'parent_id' => 6,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Retreat House',
                'label' => 'Retreat House',
                'description' => 'Retreat House',
                'image_URL' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Vendor',
                'label' => 'Vendor',
                'description' => 'Vendor',
                'image_URL' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Religious-Catholic',
                'label' => 'Religious-Catholic',
                'description' => 'Religious-Catholic',
                'image_URL' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Religious-Non-Catholic',
                'label' => 'Religious-Non-Catholic',
                'description' => 'Religious-Non-Catholic',
                'image_URL' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Contract',
                'label' => 'Contract',
                'description' => 'Contract',
                'image_URL' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Foundation',
                'label' => 'Foundation',
                'description' => 'Foundation',
                'image_URL' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}