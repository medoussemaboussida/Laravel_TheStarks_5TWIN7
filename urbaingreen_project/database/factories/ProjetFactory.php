<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Projet>
 */
class ProjetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateDebut = $this->faker->dateTimeBetween('-1 year', '+6 months');
        $dateFin = $this->faker->dateTimeBetween($dateDebut, '+1 year');

        return [
            'nom' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'statut' => $this->faker->randomElement(['planifie', 'en_cours', 'termine', 'suspendu']),
            'budget' => $this->faker->optional(0.7)->randomFloat(2, 1000, 100000),
            'localisation' => $this->faker->city(),
        ];
    }
}
