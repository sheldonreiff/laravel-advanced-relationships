<?php
namespace Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Reiff\AdvancedRelationships\HasAdvancedRelationships;

use Tests\Models\Task;

class Position extends Model
{
    use HasAdvancedRelationships;

    public function task()
    {
        return $this->belongsTo(Task::class, ['client_id', 'fund_id'], ['client_id', 'fund_id']);
    }
}