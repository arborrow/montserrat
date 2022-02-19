<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DioceseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $city_name = $this->faker->city();
        $diocese_name = 'Diocese of '.$city_name;

        return [
            'contact_type' => config('polanco.contact_type.organization'),
            'subcontact_type' => config('polanco.contact_type.diocese'),
            'do_not_email' => $this->faker->boolean(),
            'do_not_phone' => $this->faker->boolean(),
            'do_not_mail' => $this->faker->boolean(),
            'do_not_sms' => $this->faker->boolean(),
            'do_not_trade' => $this->faker->boolean(),
            'is_opt_out' => $this->faker->boolean(),
            'sort_name' => $city_name,
            'display_name' => $diocese_name,
            'legal_name' => $diocese_name,
            'image_URL' => $this->faker->word(),
            'preferred_communication_method' => $this->faker->word(),
            'preferred_language' => $this->faker->locale(),
            'preferred_mail_format' => $this->faker->word(),
            'hash' => $this->faker->word(),
            'api_key' => $this->faker->word(),
            'source' => $this->faker->word(),
            'job_title' => $this->faker->word(),
            'birth_date' => $this->faker->dateTime(),
            'is_deceased' => $this->faker->boolean(),
            'deceased_date' => $this->faker->dateTime(),
            'household_name' => $diocese_name,
            'organization_name' => $diocese_name,
            'created_date' => $this->faker->dateTime(),
            'modified_date' => $this->faker->dateTime(),
            'remember_token' => Str::random(10),
        ];
    }
}
