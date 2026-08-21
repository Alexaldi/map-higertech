<?php

namespace Database\Factories;

use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Station>
 */
class StationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['ARR', 'AWLR', 'AWS', 'AWLR_ARR', 'AGWLR', 'FM', 'EWS', 'AVWR', 'WQ', 'VNOTCH', 'OW', 'OSP']);
        $name = fake()->unique()->words(3, true);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numerify('####'),
            'station_type' => $type,
            'latitude' => fake()->latitude(-10.8, 5.8),
            'longitude' => fake()->longitude(95.0, 141.0),
            'balai_name' => 'Balai Telemetri Nusantara '.fake()->randomElement(['Barat', 'Tengah', 'Timur']),
            'organization_code' => fake()->randomElement(['BTN-BARAT', 'BTN-TENGAH', 'BTN-TIMUR']),
            'province_name' => fake()->randomElement(['Jawa Barat', 'Jawa Tengah', 'Kalimantan Timur', 'Sulawesi Selatan']),
            'regency_name' => fake()->city(),
            'district_name' => fake()->optional()->citySuffix(),
            'village_name' => fake()->optional()->streetName(),
            'river_area_name' => fake()->optional()->randomElement(['WS Andalas', 'WS Cendana', 'WS Arunika']),
            'watershed_name' => fake()->optional()->randomElement(['DAS Aruna', 'DAS Cakrawala', 'DAS Nirmala']),
            'device_id' => $type.'-DUMMY-'.fake()->unique()->numerify('####'),
            'device_status' => fake()->randomElement(['online', 'online', 'online', 'offline']),
            'timezone' => 'Asia/Jakarta',
            'reading_at' => now()->subMinutes(fake()->numberBetween(1, 240)),
            'latest_reading' => self::telemetryFor($type, fake()->numberBetween(1, 50)),
        ];
    }

    /** @return array<string, int|float|string> */
    public static function telemetryFor(string $type, int $index): array
    {
        $rainfall = $index % 4 === 0 ? 0 : round(($index % 7) * 1.35, 2);
        $waterLevel = round(0.75 + (($index % 10) * 0.23), 2);

        return match ($type) {
            'ARR' => [
                'rainfall' => $rainfall,
                'rainfall_last_hour' => round($rainfall / 3, 2),
                'intensity' => $rainfall === 0.0 ? 'Berawan' : ($rainfall < 5 ? 'Hujan Ringan' : 'Hujan Sedang'),
            ],
            'AWLR' => [
                'water_level' => $waterLevel,
                'warning_status' => $waterLevel >= 2.5 ? 'Siaga' : 'Normal',
            ],
            'AWS' => [
                'temperature' => round(24.5 + (($index % 9) * 0.6), 1),
                'humidity' => 65 + ($index % 25),
                'pressure' => 1006 + ($index % 10),
                'rainfall' => $rainfall,
                'wind_speed' => round(0.3 + (($index % 8) * 0.28), 2),
                'wind_direction' => ['Utara', 'Timur Laut', 'Timur', 'Tenggara'][$index % 4],
                'solar_radiation' => 180 + (($index % 7) * 45),
            ],
            'AWLR_ARR' => [
                'water_level' => $waterLevel,
                'warning_status' => $waterLevel >= 2.5 ? 'Siaga' : 'Normal',
                'rainfall' => $rainfall,
                'intensity' => $rainfall === 0.0 ? 'Berawan' : 'Hujan Ringan',
            ],
            'AGWLR' => [
                'groundwater_level' => round(2.4 + (($index % 8) * 0.17), 2),
                'battery_voltage' => round(12.1 + (($index % 5) * 0.12), 2),
            ],
            'FM' => [
                'flow_rate' => round(15.5 + ($index * 0.38), 2),
                'flow_total' => round(51000 + ($index * 173.24), 2),
                'flow_month' => round(4200 + ($index * 68.75), 2),
            ],
            'EWS' => [
                'warning_status' => $index % 3 === 0 ? 'Waspada' : 'Normal',
                'signal_strength' => 70 + ($index % 25),
            ],
            'AVWR' => [
                'gate_opening' => round(0.35 + (($index % 6) * 0.12), 2),
                'water_level' => $waterLevel,
            ],
            'WQ' => [
                'ph' => round(6.7 + (($index % 7) * 0.1), 1),
                'turbidity' => round(3.2 + (($index % 8) * 0.45), 2),
                'dissolved_oxygen' => round(5.8 + (($index % 5) * 0.22), 2),
            ],
            'VNOTCH' => [
                'discharge' => round(1.4 + (($index % 8) * 0.31), 2),
                'water_height' => round(0.22 + (($index % 6) * 0.08), 2),
            ],
            'OW' => [
                'observation_value' => round(1.8 + (($index % 5) * 0.2), 2),
                'condition' => 'Stabil',
            ],
            'OSP' => [
                'pump_status' => $index % 2 === 0 ? 'Aktif' : 'Siaga',
                'discharge' => round(8.5 + (($index % 7) * 0.65), 2),
            ],
            default => [],
        };
    }
}
