<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $first_name = $this->faker->firstName();
        $last_name = $this->faker->lastName();
        $sort_name = $last_name.', '.$first_name;
        $display_name = $first_name.' '.$last_name;
        $ethnicity = \App\Models\Ethnicity::get()->random();
        $religion = \App\Models\Religion::whereIsActive(1)->get()->random();
        $occupation = \App\Models\Ppd_occupation::get()->random();
        $preferred_language = \App\Models\Language::whereIsActive(1)->get()->random();
        $suffix = \App\Models\Suffix::get()->random();
        $prefix = \App\Models\Prefix::get()->random();
        $preferred_communication_method = $this->faker->numberBetween(0, 4);

        return [
            'contact_type' => $this->faker->numberBetween(1, 3),
            'subcontact_type' => $this->faker->numberBetween(4, 8),
            'do_not_email' => $this->faker->boolean(),
            'do_not_phone' => $this->faker->boolean(),
            'do_not_mail' => $this->faker->boolean(),
            'do_not_sms' => $this->faker->boolean(),
            'do_not_trade' => $this->faker->boolean(),
            'is_opt_out' => $this->faker->boolean(),
            'sort_name' => $sort_name,
            'display_name' => $display_name,
            'nick_name' => $this->faker->firstName(),
            'legal_name' => $display_name,
            'image_URL' => $this->faker->word(),
            'preferred_communication_method' => $preferred_communication_method,
            'preferred_language' => $preferred_language->name,
            'preferred_mail_format' => $this->faker->word(),
            'hash' => $this->faker->word(),
            'api_key' => $this->faker->word(),
            'source' => $this->faker->word(),
            'first_name' => $first_name,
            'middle_name' => $this->faker->firstName(),
            'last_name' => $last_name,
            'prefix_id' => $prefix->id,
            'suffix_id' => $suffix->id,
            'email_greeting_custom' => $this->faker->word(),
            'email_greeting_display' => $this->faker->word(),
            'postal_greeting_custom' => $this->faker->word(),
            'postal_greeting_display' => $this->faker->word(),
            'addressee_greeting_custom' => $this->faker->word(),
            'addressee_greeting_display' => $this->faker->word(),
            'job_title' => $this->faker->word(),
            'gender_id' => $this->faker->numberBetween(1, 2),
            'birth_date' => $this->faker->dateTime(),
            'is_deceased' => $this->faker->boolean(),
            'deceased_date' => $this->faker->dateTime(),
            'household_name' => $this->faker->name(),
            'organization_name' => $this->faker->company(),
            'sic_code' => $this->faker->word(),
            'is_deleted' => $this->faker->boolean(),
            'created_date' => $this->faker->dateTime(),
            'modified_date' => $this->faker->dateTime(),
            'remember_token' => Str::random(10),
            'sort_name_count' => $this->faker->randomNumber(),
            'ethnicity_id' => $ethnicity->id,
            'religion_id' => $religion->id,
            'occupation_id' => $occupation->id,
        ];
    }
}
