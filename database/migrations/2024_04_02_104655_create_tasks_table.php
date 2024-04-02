<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('lead_engineer_id');
            $table->unsignedBigInteger('assigned_to');
            $table->string('task_name');
            $table->integer('completion_percent');
            $table->dateTime('completion_time')->nullable();
            $table->string('status')->default('pending');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('lead_engineer_id')->references('id')->on('users');
            $table->foreign('assigned_to')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
