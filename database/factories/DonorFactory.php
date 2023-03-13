<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DonorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'donor_id' => $this->faker->randomNumber(5),
            'FName' => $this->faker->word(),
            'MInitial' => $this->faker->word(),
            'LName' => $this->faker->word(),
            'Address' => $this->faker->word(),
            'Address2' => $this->faker->word(),
            'City' => $this->faker->word(),
            'State' => $this->faker->word(),
            'Zip' => $this->faker->word(),
            'NickName' => $this->faker->word(),
            'SpouseName' => $this->faker->word(),
            'HomePhone' => $this->faker->word(),
            'WorkPhone' => $this->faker->word(),
            'EMailAddress' => $this->faker->word(),
            'FaxNumber' => $this->faker->word(),
            'worker_id' => $this->faker->randomNumber(),
            'city_id' => $this->faker->randomNumber(),
            'phase_id' => $this->faker->randomNumber(),
            'age_id' => $this->faker->randomNumber(),
            'occup_id' => $this->faker->randomNumber(),
            'church_id' => $this->faker->randomNumber(),
            'salut_id' => $this->faker->randomNumber(),
            'NameEnd' => $this->faker->word(),
            'Gender' => $this->faker->word(),
            'donation_type_id' => $this->faker->randomNumber(),
            'DonationID' => $this->faker->randomNumber(),
            'retreat_id' => $this->faker->randomNumber(),
            'retreat_date' => $this->faker->dateTime(),
            'First Visit' => $this->faker->word(),
            'Big Donor' => $this->faker->word(),
            'Old Donor' => $this->faker->word(),
            'New Date ID' => $this->faker->randomNumber(),
            'NotAvailable' => $this->faker->word(),
            'Note' => $this->faker->word(),
            'CampLetterSent' => $this->faker->word(),
            'DateLetSent' => $this->faker->dateTime(),
            'AdventDonor' => $this->faker->word(),
            'Church' => $this->faker->word(),
            'Elderhostel' => $this->faker->word(),
            'Deceased' => $this->faker->word(),
            'Spouse' => $this->faker->word(),
            'RoomNum' => $this->faker->word(),
            'Cancel' => $this->faker->word(),
            'ReqRemoval' => $this->faker->word(),
            'Note1' => $this->faker->word(),
            'Note2' => $this->faker->text(),
            'BoardMember' => $this->faker->word(),
            'NoticeSend' => $this->faker->word(),
            'Ambassador' => $this->faker->word(),
            'Knights' => $this->faker->word(),
            'AmbassadorSince' => $this->faker->word(),
            'ParkCityClub' => $this->faker->word(),
            'SpeedwayClub' => $this->faker->word(),
            'DonatedWillNotAttend' => $this->faker->word(),
            'PartyMailList' => $this->faker->word(),
            'SpiritDirect' => $this->faker->word(),
            'KofC Grand Councils' => $this->faker->word(),
            'Hispanic' => $this->faker->word(),
            'October Dinner Meeting' => $this->faker->word(),
            'Board Advisor' => $this->faker->word(),
            'cell_phone' => $this->faker->word(),
            'Emergency Contact Num' => $this->faker->word(),
            'Emergency Name' => $this->faker->word(),
            'Emergency Contact Num2' => $this->faker->word(),
            'St Rita Spiritual Exercises' => $this->faker->word(),
            'contact_id' => $this->faker->randomNumber(),
            'sort_name' => $this->faker->word(),
            'sort_name_count' => $this->faker->randomNumber(2),
        ];
    }
}
