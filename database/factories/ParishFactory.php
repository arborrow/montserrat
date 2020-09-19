<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ParishFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Parish::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->firstName;
        $parish_name = 'St. '.$name.' of '.$this->faker->city.' Parish';

        return [
            'contact_type' => config('polanco.contact_type.organization'),
            'subcontact_type' => config('polanco.contact_type.parish'),
            'do_not_email' => $this->faker->boolean,
            'do_not_phone' => $this->faker->boolean,
            'do_not_mail' => $this->faker->boolean,
            'do_not_sms' => $this->faker->boolean,
            'do_not_trade' => $this->faker->boolean,
            'is_opt_out' => $this->faker->boolean,
            'sort_name' => $parish_name,
            'display_name' => $parish_name,
            'legal_name' => $parish_name,
            'image_URL' => $this->faker->word,
            'preferred_communication_method' => $this->faker->word,
            'preferred_language' => $this->faker->locale,
            'preferred_mail_format' => $this->faker->word,
            'hash' => $this->faker->word,
            'api_key' => $this->faker->word,
            'source' => $this->faker->word,
            'job_title' => $this->faker->word,
            'birth_date' => $this->faker->dateTime(),
            'is_deceased' => $this->faker->boolean,
            'deceased_date' => $this->faker->dateTime(),
            'household_name' => $parish_name,
            'organization_name' => $parish_name,
            'created_date' => $this->faker->dateTime(),
            'modified_date' => $this->faker->dateTime(),
            'remember_token' => Str::random(10),
            /* TODO: at the moment let's not deal with pasnors/dioceses and relationships
        'diocese_id' => function () {
            return factory(App\Diocese::class)->create()->id;
        }, */
        ];
    }
}
