<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StripePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            0 => [
                'name' => 'create-stripe-payout',
                'display_name' => 'Create Stripe Payout',
                'description' => 'Create Stripe Payout',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            1 => [
                'name' => 'show-stripe-payout',
                'display_name' => 'Show Stripe Payout',
                'description' => 'Show Stripe Payout',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            2 => [
                'name' => 'update-stripe-payout',
                'display_name' => 'Update Stripe Payout',
                'description' => 'Update Stripe Payout',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            3 => [
                'name' => 'delete-stripe-payout',
                'display_name' => 'Delete Stripe Payout',
                'description' => 'Delete Stripe Payout',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            4 => [
                'name' => 'create-stripe-charge',
                'display_name' => 'Create Stripe Charge',
                'description' => 'Create Stripe Charge',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            5 => [
                'name' => 'show-stripe-charge',
                'display_name' => 'Show Stripe Charge',
                'description' => 'Show Stripe Charge',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            6 => [
                'name' => 'update-stripe-charge',
                'display_name' => 'Update Stripe Charge',
                'description' => 'Update Stripe Charge',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            7 => [
                'name' => 'delete-stripe-charge',
                'display_name' => 'Delete Stripe Charge',
                'description' => 'Delete Stripe Charge',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            8 => [
                'name' => 'import-stripe-charge',
                'display_name' => 'Import Stripe Charge',
                'description' => 'Import Stripe Charge',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            9 => [
                'name' => 'import-stripe-payout',
                'display_name' => 'Import Stripe Payout',
                'description' => 'Import Stripe Payout',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
