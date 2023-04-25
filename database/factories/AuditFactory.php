<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AuditFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_type' => \App\Models\User::class,
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'event' => $this->faker->randomElement(['updated', 'created', 'deleted']),
            'auditable_type' => 'App\Contact',
            'auditable_id' => function () {
                return \App\Models\Contact::factory()->create()->id;
            },
            'old_values' => null,
            'new_values' => null,
            'url' => $this->faker->url(),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'tags' => null,
            'created_at' => $this->faker->dateTimeThisMonth(),
            'updated_at' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
