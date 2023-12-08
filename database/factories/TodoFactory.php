<?php

namespace Database\Factories;

use App\Enums\TodoStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(rand(5, 8)),
            'status' => fake()->randomElement(array_column(TodoStatus::cases(), 'value'))
        ];
    }
}
