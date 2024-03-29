<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'file_type_id' => null,
            'mime_type' => null,
            'uri' => null,
            'document' => null,
            'description' => $this->faker->sentence(),
            'upload_date' => $this->faker->dateTime(),
            'remember_token' => Str::random(10),
            'entity' => null,
            'entity_id' => $this->faker->randomDigit(),
        ];
    }
}
