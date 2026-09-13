<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::query()->inRandomOrder()->value('id'),
            'title' => fake()->sentence(4),
            'description' => fake()->optional()->paragraph(),
            'priority' => fake()->randomElement(Task::PRIORITIES),
            'status' => fake()->randomElement(Task::STATUSES),
            'due_date' => fake()->dateTimeBetween('-1 week', '+3 weeks'),
        ];
    }

    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'due_date' => fake()->dateTimeBetween('-2 weeks', '-1 day'),
        ]);
    }
}
