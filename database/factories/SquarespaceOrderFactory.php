<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use App\Models\Prefix;
use App\Models\SquarespaceInventory;
use Illuminate\Database\Eloquent\Factories\Factory;

// TODO:: consider creating a certain percentage of the orders with existing contacts in the database for easier testing of edit page

class SquarespaceOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $inventory = SquarespaceInventory::where('id', '<', 10)->first();
        $prefix = Prefix::get()->random();
        $couple_prefix = Prefix::get()->random();
        $address_street = $this->faker->streetAddress();
        $address_supplemental = $this->faker->secondaryAddress();
        $address_city = $this->faker->city();
        $address_state = $this->faker->state();
        $address_zip = $this->faker->postcode();
        $full_address = $address_street.', '.$address_supplemental.', '.$address_city.', '.$address_state.' '.$address_zip.' US';
        $retreat_couple = $this->faker->randomElement(['Single', 'Couple', 'Individual', 'Pareja']);
        $is_couple = ($retreat_couple == 'Couple' || $retreat_couple = 'Pareja') ? 1 : 0;

        return [
            'order_number' => $this->faker->randomNumber(),
            'retreat_category' => $inventory->name,
            'retreat_sku' => $this->faker->uuid(),
            'retreat_description' => $this->faker->sentence(),
            'retreat_dates' => $this->faker->monthName().' '.$this->faker->numberBetween(1, 9).' - '.$this->faker->numberBetween(10, 20).', '.$this->faker->year(),
            'retreat_start_date' => $this->faker->date(),
            'retreat_idnumber' => $this->faker->year().$this->faker->numberBetween(10, 99),
            'retreat_registration_type' => $this->faker->randomElement(['Registration and Deposit', 'Registration and Payment in Full', 'Registro y depósito', 'Registro y pago completo']),
            'retreat_couple' => $this->faker->randomElement(['Single', 'Couple', 'Individual', 'Pareja']),
            'retreat_quantity' => 1,
            'deposit_amount' => $this->faker->randomElement(['50', '390']),
            'unit_price' => $this->faker->randomElement(['50', '390']),
            'title' => $prefix->name,
            'name' => $this->faker->firstname().' '.$this->faker->lastname(),
            'full_address' => $full_address,
            'address_street' => $address_street,
            'address_supplemental' => $address_supplemental,
            'address_city' => $address_city,
            'address_state' => $address_state,
            'address_zip' => $address_zip,
            'address_country' => 'US',
            'email' => $this->faker->email(),
            'mobile_phone' => $this->faker->phoneNumber(),
            'home_phone' => $this->faker->phoneNumber(),
            'work_phone' => $this->faker->phoneNumber(),
            'emergency_contact' => $this->faker->name(),
            'emergency_contact_relationship' => $this->faker->randomElement(['Husband', 'Wife', 'Sibling', 'Son', 'Daughter', 'Friend', 'Boss']),
            'emergency_contact_phone' => $this->faker->phoneNumber(),
            'dietary' => $this->faker->randomElement(['', 'Diabetic', 'Low sodium', 'Allergic to dairy', 'Allergic to peanuts', 'Gluten free']),
            'room_preference' => $this->faker->randomElement(['', '1st Floor', '2nd Floor']),
            'preferred_language' => $this->faker->randomElement(['', 'English', 'Spanish', 'Vietnamese']),
            'date_of_birth' => $this->faker->dateTimeBetween('-60 years', '-20 years'),
            'parish' => 'St. '.$this->faker->firstname().' '.$this->faker->lastname().' Parish',
            'comments' => $this->faker->sentence(),
            'couple_date_of_birth' => ($is_couple) ? $this->faker->dateTimeBetween('-60 years', '-20 years') : null,
            'couple_dietary' => ($is_couple) ? $this->faker->randomElement(['', 'Diabetic', 'Low sodium', 'Allergic to dairy', 'Allergic to peanuts', 'Gluten free']) : null,
            'couple_email' => ($is_couple) ? $this->faker->email() : null,
            'couple_emergency_contact' => ($is_couple) ? $this->faker->name() : null,
            'couple_emergency_contact_relationship' => ($is_couple) ? $this->faker->randomElement(['Husband', 'Wife', 'Sibling', 'Son', 'Daughter', 'Friend', 'Boss']) : null,
            'couple_emergency_contact_phone' => ($is_couple) ? $this->faker->phoneNumber() : null,
            'couple_title' => ($is_couple) ? $couple_prefix->name : null,
            'couple_name' => ($is_couple) ? $this->faker->firstname().' '.$this->faker->lastname() : null,
            'couple_mobile_phone' => ($is_couple) ? $this->faker->phoneNumber() : null,
            'gift_certificate_number' => $this->faker->numberBetween(22000, 22999),
            'gift_certificate_year_issued' => $this->faker->year(),
            'additional_names_and_phone_numbers' => null,
            'message_id' => $this->faker->randomNumber(),
            'event_id' => null,
            'contact_id' => null,
            'couple_contact_id' => null,
            'participant_id' => null,
            'touchpoint_id' => null,
            'stripe_charge_id' => null,
            'email_body' => null,
            'is_processed' => $this->faker->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
