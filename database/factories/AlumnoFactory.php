<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alumno>
 */
class AlumnoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'telefono' => fake()->phoneNumber(),
            'edad' => rand(4, 10),
            'password' => fake()->password,
            'email' => fake()->unique()->safeEmail(),
            'sexo' => fake()->randomElement(['hombre', 'mujer']),
        ];
    }
}
