<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactTypeTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        DB::table('contact_type')->delete();

        DB::table('contact_type')->insert([
            0 => [
                'id' => 1,
                'name' => 'Individual',
                'label' => 'Individual',
                'description' => null,
                'image_URL' => null,
                'parent_id' => null,
                'is_active' => 1,
                'is_reserved' => 1,
                'status' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id' => 2,
                'name' => 'Household',
                'label' => 'Household',
                'description' => null,
                'image_URL' => null,
                'parent_id' => null,
                'is_active' => 1,
                'is_reserved' => 1,
                'status' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'id' => 3,
                'name' => 'Organization',
                'label' => 'Organization',
                'description' => null,
                'image_URL' => null,
                'parent_id' => null,
                'is_active' => 1,
                'is_reserved' => 1,
                'status' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            3 => [
                'id' => 4,
                'name' => 'Parish',
                'label' => 'Parish',
                'description' => null,
                'image_URL' => null,
                'parent_id' => 5,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            4 => [
                'id' => 5,
                'name' => 'Diocese',
                'label' => 'Diocese',
                'description' => null,
                'image_URL' => null,
                'parent_id' => 3,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            5 => [
                'id' => 6,
                'name' => 'Province',
                'label' => 'Province',
                'description' => 'Jesuit Province',
                'image_URL' => null,
                'parent_id' => 3,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            6 => [
                'id' => 7,
                'name' => 'Community',
                'label' => 'Jesuit Community',
                'description' => 'Jesuit Community',
                'image_URL' => null,
                'parent_id' => 6,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            7 => [
                'id' => 8,
                'name' => 'Retreat House',
                'label' => 'Retreat House',
                'description' => 'Retreat House',
                'image_URL' => null,
                'parent_id' => 3,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            8 => [
                'id' => 9,
                'name' => 'Vendor',
                'label' => 'Vendor',
                'description' => 'Vendor',
                'image_URL' => null,
                'parent_id' => 3,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            9 => [
                'id' => 10,
                'name' => 'Religious-Catholic',
                'label' => 'Religious-Catholic',
                'description' => 'Religious-Catholic',
                'image_URL' => null,
                'parent_id' => 3,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            10 => [
                'id' => 11,
                'name' => 'Religious-Non-Catholic',
                'label' => 'Religious-Non-Catholic',
                'description' => 'Religious-Non-Catholic',
                'image_URL' => null,
                'parent_id' => 3,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            11 => [
                'id' => 12,
                'name' => 'Contract',
                'label' => 'Contract',
                'description' => 'Contract',
                'image_URL' => null,
                'parent_id' => 3,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            12 => [
                'id' => 13,
                'name' => 'Foundation',
                'label' => 'Foundation',
                'description' => 'Foundation',
                'image_URL' => null,
                'parent_id' => 3,
                'is_active' => 1,
                'is_reserved' => 0,
                'status' => '',
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
