<?php

namespace Database\Factories;

use App\Enums\EstimationType;
use App\Enums\Priorities;
use App\Enums\TaskStatus;
use App\Models\Project;
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
    public function definition()
    {
        return [
            'title'                 => fake()->sentence(3),
            'description'           => fake()->sentence(100),
            'status'                => fake()->randomElement(TaskStatus::values()),
            'priority'              => fake()->randomElement(Priorities::values()),
            'progression'           => random_int(1, 100),
            'estimated_duration'    => random_int(1, 10),
            'estimation_type'       => fake()->randomElement(EstimationType::values()),
            'deadline'              => fake()->dateTime(),
            'started_at'            => fake()->dateTime(),
            'finished_at'           => fake()->dateTime(),
            'project_id'            => Project::factory()
        ];
    }
}
