<?php
namespace Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Reiff\AdvancedRelationships\HasAdvancedRelationships;

use Tests\Models\Task;

class Transaction extends Model
{
    use HasAdvancedRelationships;

    protected $casts = [
        'json_col' => 'array',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, ['json_col->trans_date', 'json_col->trans_type'], ['json_col->date', 'json_col->type']);
    }
}