<?php
namespace Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Reiff\AdvancedRelationships\HasAdvancedRelationships;

use Tests\Models\Position;
use Tests\Models\Transaction;
use Tests\Models\TaskType;
use Tests\Models\User;

class Task extends Model
{
    use HasAdvancedRelationships;

    protected $casts = [
        'json_col' => 'array',
    ];

    public function position()
    {
        return $this->hasOne(Position::class, ['client_id', 'fund_id'], ['client_id', 'fund_id']);
    }

    public function positions()
    {
        return $this->hasMany(Position::class, ['client_id', 'fund_id'], ['client_id', 'fund_id']);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, ['json_col->category', 'json_col->type'], ['json_col->category', 'json_col->type']);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, ['json_col->category', 'json_col->type'], ['json_col->category', 'json_col->type']);
    }

    public function type()
    {
        return $this->belongsTo(TaskType::class, 'task_type_id', 'id');
    }

    public function assignee()
    {
        return $this->hasOne(User::class, 'id', 'json_col->assignee');
    }

    public function eligibleAssignees()
    {
        return $this->hasMany(User::class, 'json_col->group', 'json_col->assignmentGroup');
    }
}