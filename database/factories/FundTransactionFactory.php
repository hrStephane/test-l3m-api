<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FundTransactions>
 */
class FundTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'reference' => $this->faker->uuid,
            'type' => $this->faker->randomElement(['deposit', 'withdrawal']),
            'amount' => $this->faker->randomFloat(2, 0, 999999),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'description' => $this->faker->text,
        ];
    }
}
