<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Call;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Call>
 */
class CallFactory extends Factory
{
    protected $model = Call::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => \App\Models\Customer::inRandomOrder()->first()->id,
            'agent_id' => \App\Models\Agent::inRandomOrder()->first()->id,
            'duration' => $this->faker->numberBetween(60, 3600), // Call duration between 1 and 60 minutes
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
