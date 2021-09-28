<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// TODO: to avoid confusion with agc letters in Spanish I'm limiting testing for now to $current_user

class DonationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Donation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $description = \App\Models\DonationType::whereIsActive(1)->get()->random();

        return [
            'donation_description' => $description->name,
            'donation_date' => $this->faker->dateTime(),
            'donation_amount' => $this->faker->randomFloat(2, 0, 100000),
            'donation_install' => $this->faker->randomFloat(2, 0, 5000),
            'terms' => $this->faker->text(),
            'start_date' => $this->faker->dateTime(),
            'end_date' => $this->faker->dateTime(),
            'payment_description' => $this->faker->word(),
            'Notes' => $this->faker->text(),
            'Notes1' => $this->faker->text(),
            'Notice' => $this->faker->word(),
            'Arrupe Donation Description' => $this->faker->word(),
            'Target Amount' => $this->faker->randomNumber(),
            'Donation Type ID' => $this->faker->randomNumber(),
            'Thank You' => $this->faker->randomElement($array = ['Y', 'N']),
            'AGC Donation Description' => $this->faker->word(),
            'Pledge' => $this->faker->word(),
            'contact_id' => function () {
                return \App\Models\Contact::factory()->create([
                    'preferred_language' => 'en_US',
                ])->id;
            },
            'event_id' => function () {
                return \App\Models\Retreat::factory()->create()->id;
            },
            'remember_token' => Str::random(10),
        ];
    }
}
