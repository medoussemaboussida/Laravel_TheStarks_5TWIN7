<?php

namespace Database\Factories;

use App\Models\Projet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evenement>
 */
class EvenementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateDebut = $this->faker->dateTimeBetween('-6 months', '+1 year');
        $dateFin = $this->faker->dateTimeBetween($dateDebut, $dateDebut->format('Y-m-d H:i:s') . ' +8 hours');

        return [
            'nom' => $this->faker->sentence(2),
            'description' => $this->faker->paragraph(2),
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'lieu' => $this->faker->address(),
            'nombre_participants_max' => $this->faker->optional(0.6)->numberBetween(10, 200),
            'statut' => $this->faker->randomElement(['planifie', 'en_cours', 'termine', 'annule']),
            'projet_id' => Projet::factory(),
        ];
    }
}
