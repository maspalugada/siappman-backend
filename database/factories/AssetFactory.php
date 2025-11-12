<?php

namespace Database\Factories;

use App\Models\Asset;
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
        $instrumentTypes = [
            'Pressure Gauge',
            'Temperature Sensor',
            'Flow Meter',
            'Level Transmitter',
            'Control Valve',
            'Pump',
            'Motor',
            'Switch',
            'Transducer',
            'Analyzer'
        ];

        $units = [
            'Bar',
            'Psi',
            'Celsius',
            'Fahrenheit',
            'Liter/min',
            'm³/h',
            'mm',
            'cm',
            'Meter',
            'RPM',
            'Volt',
            'Ampere',
            'Hz'
        ];

        $locations = [
            'Workshop A',
            'Workshop B',
            'Production Line 1',
            'Production Line 2',
            'Storage Area',
            'Maintenance Room',
            'Control Room',
            'Laboratory'
        ];

        return [
            'name' => $this->faker->words(3, true),
            'instrument_type' => $this->faker->randomElement($instrumentTypes),
            'unit' => $this->faker->randomElement($units),
            'location' => $this->faker->randomElement($locations),
            'description' => $this->faker->optional()->paragraph(),
            'qr_code' => 'ASSET-' . strtoupper(Str::random(8)),
            'specifications' => $this->faker->optional()->randomElements(['Range: 0-100', 'Accuracy: ±0.5%', 'Power: 24VDC'], 2),
            'status' => $this->faker->randomElement(['active', 'inactive', 'maintenance']),
        ];
    }
}
