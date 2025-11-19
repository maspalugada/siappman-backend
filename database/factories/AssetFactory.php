<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\InstrumentType;
use App\Models\Unit;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Asset::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'instrument_type' => InstrumentType::factory()->create()->name,
            'unit' => Unit::factory()->create()->name,
            'location' => Location::factory()->create()->name,
            'description' => $this->faker->optional()->paragraph(),
            'qr_code' => 'ASSET-' . strtoupper(Str::uuid()->toString()),
            'specifications' => $this->faker->optional()->randomElements(['Range: 0-100', 'Accuracy: ±0.5%', 'Power: 24VDC'], 2),
            'status' => $this->faker->randomElement([Asset::STATUS_READY, Asset::STATUS_WASHING, Asset::STATUS_STERILIZING, Asset::STATUS_IN_USE, Asset::STATUS_MAINTENANCE]),
        ];
    }
}
