<?php
namespace Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Reiff\AdvancedRelationships\HasAdvancedRelationships;

use Tests\Models\Task;

class User extends Model
{
    use HasAdvancedRelationships;

    protected $casts = [
        'json_col' => 'array',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'id', 'json_col->assignee');
    }
}