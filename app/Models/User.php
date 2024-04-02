<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'role'];

    public function managedProjects()
    {
        return $this->hasMany(Project::class, 'project_manager_id');
    }

    public function leadProjects()
    {
        return $this->belongsToMany(Project::class, 'project_leads', 'lead_engineer_id', 'project_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }
}
