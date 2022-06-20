<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SquarespaceInventory;
use App\Models\Retreat;

class SquarespaceContributionFactory extends Factory
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
        $inventory = SquarespaceInventory::where('id','<',10)->first();
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
        $event = Retreat::whereIsActive(1)->get()->random();
        $retreat_description = ($is_retreat) ? '#'.$retreat_number . ' ' . $inventory->name . 
        ' (' . $this->faker->monthName() . ' ' . 
        $this->faker->numberBetween(1,10) . '-' . 
        $this->faker->numberBetween(11,20).', '.
        $year .')' : null; 
        return [

            'message_id' => $this->faker->randomNumber(), 
            'event_id' => null, 
            'contact_id' => null,
            'name' => $name, 
            'email' => $this->faker->email(), 
            'address_street' => $address_street, 
            'address_supplemental' => $address_supplemental, 
            'address_city' => $address_city, 
            'address_state' => $address_state, 
            'address_zip' => $address_zip, 
            'address_country' => 'US', 
            'phone' => $this->faker->phoneNumber(), 
            'retreat_description' => $retreat_description,
            'offering_type' => ($is_retreat) ? $this->faker->randomElement(['Pre-Retreat offering','Post-Retreat offering']) : null, 
            'amount' => $this->faker->numberBetween(50,500), 
            'fund' => ($is_retreat) ? null : $this->faker->randomElement(array_flip(config('polanco.donation_descriptions'))), 
            'idnumber' => $event->idnumber,
            'comments' => $this->faker->sentence(), 
            'is_processed' => $this->faker->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
