<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PredictionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    // List status buat diacak
    $statuses = ['RISIKO TINGGI', 'RISIKO RENDAH', 'TIDAK ADA RISIKO'];

    return [
        'patient_name'      => fake('id_ID')->name(), // Nama asli Indonesia gess!
        'age'               => fake()->numberBetween(20, 85),
        'gender'            => fake()->randomElement(['Laki-laki', 'Perempuan']),
        'bmi'               => fake()->randomFloat(1, 18, 35),
        'avg_glucose_level' => fake()->randomFloat(2, 70, 250),
        'status_label'      => fake()->randomElement($statuses),
        'created_at'        => fake()->dateTimeBetween('-6 months', 'now'), // Biar bisa buat grafik statistik 6 bulan
    ];
}
}
