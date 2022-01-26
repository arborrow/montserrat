<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contact_id' => function () {
                return \App\Models\Contact::factory()->create([
                    'contact_type' => 1,
                    'subcontact_type' => null,
                    'is_deceased' => 0,
                    'deceased_date' => null,
                ])->id;
            },
            'event_id' => function () {
                return \App\Models\Retreat::factory()->create()->id;
            },
            'status_id' => config('polanco.registration_status_id.registered'),
            'role_id' => config('polanco.participant_role_id.retreatant'),
            'register_date' => $this->faker->dateTime(),
            'source' => $this->faker->randomElement(config('polanco.registration_source')),
            'fee_level' => $this->faker->text(),
            'is_test' => $this->faker->boolean(),
            'is_pay_later' => $this->faker->boolean(),
            'fee_amount' => $this->faker->randomFloat(),
            'registered_by_id' => null,
            'discount_id' => null,
            'fee_currency' => $this->faker->word(),
            'campaign_id' => null,
            'discount_amount' => $this->faker->randomNumber(),
            'cart_id' => null,
            'must_wait' => $this->faker->randomNumber(),
            'remember_token' => Str::random(10),
            'registration_confirm_date' => $this->faker->dateTime(),
            'attendance_confirm_date' => $this->faker->dateTime(),
            'confirmed_by' => $this->faker->word(),
            'notes' => $this->faker->text(),
            'deposit' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000),
            'canceled_at' => null,
            'arrived_at' => $this->faker->dateTime(),
            'departed_at' => $this->faker->dateTime(),
            'room_id' => null,
            'donation_id' => null,
            'ppd_source' => $this->faker->word(),
        ];
    }
}
