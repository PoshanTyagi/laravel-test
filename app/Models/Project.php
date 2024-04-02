<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = ['project_name', 'project_manager_id'];

    public function manager()
    {
        return $this->belongsTo(User::class, 'project_manager_id');
    }

    public function leads()
    {
        return $this->belongsToMany(User::class, 'project_leads', 'project_id', 'lead_engineer_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }
}
