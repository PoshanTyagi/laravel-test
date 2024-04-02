<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'lead_engineer_id', 'assigned_to', 'task_name', 'completion_percent'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function leadEngineer()
    {
        return $this->belongsTo(User::class, 'lead_engineer_id');
    }

    public function engineer()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
