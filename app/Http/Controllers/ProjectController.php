<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/projects",
     *      description="Get all projects",
     *      summary="Get all projects",
     *      @OA\Response(
     *          response=200,
     *          description="Successful Operation",
     *          @OA\JsonContent(),
     *      ),
     * )
     */
    public function showProjects()
    {
        $projects = Project::query()
            ->with('manager:id,name')
            ->withCount(['leads as leads_count' => function ($query) {
                $query->distinct('engineer_id');
            }])
            ->withCount(['tasks as tasks_count' => function ($query) {
                $query->select(DB::raw('count(distinct assigned_to)'));
            }])
            ->with(['milestones' => function ($query) {
                $query->selectRaw('project_id, AVG(completion_percent) as average_completion')->groupBy('project_id');
            }])
            ->get()
            ->map(function ($project) {
                $averageCompletion = optional($project->milestones->first())->average_completion ?? 0;

                return [
                    'project_name' => $project->project_name,
                    'project_manager' => $project->manager->name ?? 'N/A',
                    'lead_engineer_count' => $project->leads_count,
                    'engineer_count' => $project->tasks_count,
                    'milestone_completion_percentage' => round($averageCompletion, 2),
                ];
            });

        return response()->json($projects);
    }

    /**
     * @OA\Get(
     *      path="/api/project-details",
     *      description="Get all projects with details",
     *      summary="Get all projects with details",
     *      @OA\Response(
     *          response=200,
     *          description="Successful Operation",
     *          @OA\JsonContent(),
     *      ),
     * )
     */
    public function showProjectDetails()
    {
        $projects = Project::with(['leads', 'tasks.engineer'])
            ->get()
            ->map(function ($project) {
                $leadEngineers = $project->leads->map(function ($lead) {
                    return $lead->name;
                });

                $tasksDetails = $project->tasks->map(function ($task) {
                    return [
                        'task_name' => $task->task_name,
                        'assigned_engineer' => $task->engineer->name ?? 'N/A',
                        'completion_percent' => $task->completion_percent,
                    ];
                });

                return [
                    'project_name' => $project->project_name,
                    'lead_engineers' => $leadEngineers,
                    'tasks' => $tasksDetails,
                ];
            });

        return response()->json($projects);
    }

    /**
     * @OA\Get(
     *      path="/api/project-tasks",
     *      description="Get all projects with tasks details",
     *      summary="Get all projects with tasks details",
     *      @OA\Response(
     *          response=200,
     *          description="Successful Operation",
     *          @OA\JsonContent(),
     *      ),
     * )
     */
    public function showProjectTasksWithDetails()
    {
        $projects = Project::with(['tasks' => function ($query) {
            $query->with('leadEngineer');
        }])->get();

        $projectTasks = $projects->map(function ($project) {
            $tasksDetails = $project->tasks->map(function ($task) {
                return [
                    'task_name' => $task->task_name,
                    'lead_name' => $task->leadEngineer->name ?? 'N/A',
                    'completion_time' => $task->completion_time ? $task->completion_time->toDateTimeString() : 'Not Completed',
                    'status' => $task->status,
                ];
            });

            return [
                'project_name' => $project->project_name,
                'tasks' => $tasksDetails,
            ];
        });

        return response()->json($projectTasks);
    }

}
