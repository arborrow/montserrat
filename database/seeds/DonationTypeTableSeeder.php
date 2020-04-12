<?php

use Illuminate\Database\Seeder;

class DonationTypeTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('donation_type')->delete();

        \DB::table('donation_type')->insert([
            0 => [
                'id' => 1,
                'label' => 'Retreat Offering',
                'value' => '1',
                'name' => 'Retreat Offering',
                'description' => 'Retreat Offering',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            1 => [
                'id' => 11,
                'label' => 'Books',
                'value' => '11',
                'name' => 'Books',
                'description' => 'Books',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            2 => [
                'id' => 24,
                'label' => 'Miscellaneous',
                'value' => '25',
                'name' => 'Miscellaneous',
                'description' => 'Miscellaneous',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            3 => [
                'id' => 107,
                'label' => 'Day Only Events',
                'value' => '111',
                'name' => 'Day Only Events',
                'description' => 'Day Only Events',
                'is_default' => 0,
                'is_reserved' => 0,
                'is_active' => 1,
                'deleted_at' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            4 => [
                'id' => 115,
                'label' => 'Deposit',
                'value' => '119',
                'name' => 'Deposit',
                'description' => 'Deposit',
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
