<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'description', 'completion_percent'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
