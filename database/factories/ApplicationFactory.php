<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'company_name' => fake()->company(),
            'job_title' => fake()->jobTitle(),
            'job_url' => fake()->optional()->url(),
            'status' => fake()->randomElement(['en_attente', 'en_cours', 'entretien_planifie', 'offre_recue', 'refusee', 'acceptee']),
            'priority' => fake()->randomElement(['basse', 'moyenne', 'haute', 'urgente']),
            'notes' => fake()->optional()->paragraph(),
            'application_date' => fake()->date(max: 'now'),
        ];
    }
}
