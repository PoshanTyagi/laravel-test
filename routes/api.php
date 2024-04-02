<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/projects', [ProjectController::class, 'showProjects']);
Route::get('/project-details', [ProjectController::class, 'showProjectDetails']);
Route::get('/project-tasks', [ProjectController::class, 'showProjectTasksWithDetails']);