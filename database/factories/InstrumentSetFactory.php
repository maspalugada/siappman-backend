<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InstrumentSet>
 */
class InstrumentSetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence,
            'qr_code' => 'SET-' . strtoupper(\Illuminate\Support\Str::uuid()->toString()),
            'status' => $this->faker->randomElement([\App\Models\InstrumentSet::STATUS_READY, \App\Models\InstrumentSet::STATUS_WASHING]),
        ];
    }
}
