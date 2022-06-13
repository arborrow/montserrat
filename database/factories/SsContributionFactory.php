<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SsInventory;
use App\Models\Prefix;

class SsContributionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     * 
     * id , message_id , event_id , contact_id, name , email , address_street , address_supplemental , address_city , address_state , address_zip , address_country , phone , retreat_description , offering_type , amount , fund , idnumber , comments , is_processed 
     * 
     * retreat_description = #17 Women's Retreat (May 12-15, 2022)
     * 
     * // TODO: create factory based on whether it is a retreat or regular donation
     * 
     */
    public function definition()
    {
        $inventory = SsInventory::where('id','<',10)->first();
        $address_street = $this->faker->streetAddress();
        $address_supplemental = $this->faker->secondaryAddress();
        $address_city = $this->faker->city();
        $address_state = $this->faker->state();
        $address_zip = $this->faker->postcode();
        $full_address =  $address_street.', '.$address_supplemental.', '.
            $address_city . ', '.$address_state.' '.$address_zip.' US';
        $year = $this->faker->year();
        $retreat_number = $this->faker->numberBetween(10,99);
        $is_retreat = $this->faker->boolean();
        $name = $this->faker->firstName() . " " . $this->faker->lastName(); 

        return [

            'message_id' => $this->faker->randomNumber(), 
            'event_id' => null, 
            'contact_id' => null, 
            'email' => $this->faker->email(), 
            'address_street' => $address_street, 
            'address_supplemental' => $address_supplemental, 
            'address_city' => $address_city, 
            'address_state' => $address_state, 
            'address_zip' => $address_zip, 
            'address_country' => 'US', 
            'phone' => $this->faker->phoneNumber(), 
            'retreat_description' => $retreat_number . ' ' . $inventory->name . 
                ' (' . $this->faker->monthName() . ' ' . 
                $this->faker->numberBetween(1-10) . '-' . 
                $this->faker->numberBetween(11-20).', '.
                $year, 
            'offering_type' => $this->faker->randomElement(['Pre-Retreat offering','Post-Retreat offering']), 
            'amount' => $this->faker->numberBetween(50,500), 
            'fund' => $this->faker->randomElement(config('polanco.donation_descriptions')), 
            'idnumber' => $year . $retreat_number,
            'comments' => $this->faker->sentence(), 
            'is_processed' => $this->faker->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
