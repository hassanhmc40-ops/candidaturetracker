<?php

namespace Database\Factories;

use App\Models\Interview;
use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class InterviewFactory extends Factory
{
    protected $model = Interview::class;

    public function definition(): array
    {
        return [
            'application_id' => Application::factory(),
            'type' => fake()->randomElement(['telephone', 'visioconference', 'technique', 'rh', 'presentiel', 'entretien_final']),
            'scheduled_date' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'scheduled_time' => fake()->time('H:i'),
            'preparation_notes' => fake()->optional()->paragraph(),
            'result' => fake()->optional()->randomElement(['en_attente', 'reussi', 'echoue', 'annule']),
        ];
    }
}
