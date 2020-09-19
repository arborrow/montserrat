<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $payment_methods = config('polanco.payment_method');

        return [
            'donation_id' => function () {
                return \App\Models\Donation::factory()->create()->donation_id;
            },
            'payment_amount' => $this->faker->randomFloat(2, 0, 100000),
            'payment_date' => $this->faker->dateTime(),
            'payment_description' => $this->faker->randomElement($payment_methods),
            'cknumber' => $this->faker->word,
            'ccnumber' => $this->faker->word,
            'expire_date' => $this->faker->dateTime(),
            'authorization_number' => $this->faker->word,
            'note' => $this->faker->word,
            'ty_letter_sent' => $this->faker->word,
            'remember_token' => Str::random(10),
        ];
    }
}
