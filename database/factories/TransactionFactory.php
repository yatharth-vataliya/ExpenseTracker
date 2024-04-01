<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $itemUnits = [
            'litre',
            'kg',
            'Pack',
        ];

        return [
            'user_id' => auth()->id(),
            'description' => fake()->text(20),
            'item_unit' => $itemUnits[random_int(0, 2)],
            'item_count' => random_int(1, 10),
            'item_price' => random_int(50, 200),
            'transaction_date' => now()->format('Y-m-d'),
        ];
    }
}
