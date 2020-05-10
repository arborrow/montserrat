<?php

use Illuminate\Database\Seeder;

class FileTypeTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('file_type')->delete();

        \DB::table('file_type')->insert([
            0 => [
                'id' => 1,
                'label' => 'Attachment',
                'value' => 'Attachment',
                'name' => 'Attachment',
                'description' => 'Contact attachment',
                'is_default' => 1,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id' => 2,
                'label' => 'Schedule',
                'value' => 'Schedule',
                'name' => 'Schedule',
                'description' => 'Retreat schedule',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'id' => 3,
                'label' => 'Evaluation',
                'value' => 'Evaluation',
                'name' => 'Evaluation',
                'description' => 'Retreat evaluation',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            3 => [
                'id' => 4,
                'label' => 'Contract',
                'value' => 'Contract',
                'name' => 'Contract',
                'description' => 'Event contract',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            4 => [
                'id' => 5,
                'label' => 'Photo',
                'value' => 'Photo',
                'name' => 'Photo',
                'description' => 'Retreat group photo',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            5 => [
                'id' => 6,
                'label' => 'Avatar',
                'value' => 'Avatar',
                'name' => 'Avatar',
                'description' => 'Contact avatar',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            6 => [
                'id' => 7,
                'label' => 'Event attachment',
                'value' => 'Event attachment',
                'name' => 'Event attachment',
                'description' => 'Event attachment',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],

        ]);
    }
}
