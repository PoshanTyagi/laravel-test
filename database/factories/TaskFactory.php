<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
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
            'project_id' => function () {
                return Project::factory()->create()->id;
            },
            'lead_engineer_id' => function () {
                return User::factory()->create(['role' => 'Lead_Engineer'])->id;
            },
            'assigned_to' => function () {
                return User::factory()->create(['role' => 'Engineer'])->id;
            },
            'task_name' => fake()->sentence,
            'completion_percent' => fake()->numberBetween(0, 100),
        ];
    }
}
