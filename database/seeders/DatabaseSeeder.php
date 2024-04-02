<?php

namespace Database\Seeders;

use App\Models\Milestone;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $projectManagers = User::factory()->count(10)->create(['role' => 'Project_Manager']);
        $leadEngineers = User::factory()->count(15)->create(['role' => 'Lead_Engineer']);
        $engineers = User::factory()->count(50)->create(['role' => 'Engineer']);

        $projects = Project::factory()->count(10)->make()->each(function ($project) use ($projectManagers) {
            $project->project_manager_id = $projectManagers->random()->id;
            $project->save();
        });

        foreach ($projects as $project) {
            $leadsForProject = $leadEngineers->random(rand(1, 3))->pluck('id');
            $project->leads()->attach($leadsForProject);

            Task::factory()->count(5)->create([
                'project_id' => $project->id,
                'lead_engineer_id' => $leadsForProject->random(),
                'assigned_to' => $engineers->random()->id,
            ]);

            Milestone::factory()->count(3)->create([
                'project_id' => $project->id,
            ]);
        }
    }
}
