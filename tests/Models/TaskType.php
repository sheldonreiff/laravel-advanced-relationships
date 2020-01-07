<?php
namespace Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Reiff\AdvancedRelationships\HasAdvancedRelationships;

use Tests\Models\Task;

class TaskType extends Model
{
    use HasAdvancedRelationships;
    
    public function task()
    {
        return $this->hasOne(Task::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}