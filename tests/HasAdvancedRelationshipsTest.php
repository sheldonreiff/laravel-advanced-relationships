<?php

namespace Tests;

use Tests\Models\Position;
use Tests\Models\Task;
use Tests\Models\TaskType;
use Tests\Models\Transaction;
use Tests\Models\User;

class HasAdvancedRelationshipsTest extends TestCase
{
    /** @test */
    public function has_one_through_multi_column()
    {
        /** Task->Position */
        $task = Task::first();
        $taskPosition = $task->position;
        $position = Position::first();

        $this->assertTrue(
            $taskPosition->is($position)
        );
    }

    /** @test */
    public function has_many_through_multi_column()
    {
        /** Task->Position */
        $task = Task::first();
        $taskPositions = $task->positions;
        $positions = Position::where('client_id', 1)
            ->where('fund_id', 2)
            ->get();

        $this->assertEquals($taskPositions->count(), 2);
        $this->assertEquals($positions->count(), 2);

        $taskPositions->each( function($position, $index) use($positions) {
            $this->assertTrue(
                $position->is($positions[$index])
            );
        });
    }

    /** @test */
    public function belongs_to_through_multi_column()
    {
        /** Position->Task */
        $task = Task::first();
        $position = Position::first();
        $positionTask = $position->task;

        $this->assertTrue(
            $positionTask->is($task)
        );
    }

    /** @test */
    public function has_one_through_multi_column_with_json()
    {
        /** Task->Transaction */
        $task = Task::find(3);
        $taskTransaction = $task->transaction;
        $transaction = Transaction::first();

        $this->assertTrue(
            $taskTransaction->is($transaction)
        );
    }

    /** @test */
    public function has_many_through_multi_column_with_json()
    {
        /** Task->Transaction */
        $task = Task::find(3);
        $taskTransactions = $task->transactions;
        $transactions = Transaction::whereIn('id', [1,2])
            ->get();

        $this->assertEquals($taskTransactions->count(), 2);
        $this->assertEquals($transactions->count(), 2);

        $taskTransactions->each( function($taskTransaction, $index) use($transactions) {
            $this->assertTrue(
                $taskTransaction->is($transactions[$index])
            );
        });
    }

    /** @test */
    public function belongs_to_through_multi_column_with_json()
    {
        /** Transaction->Task */
        $transaction = Transaction::first();
        $transactionTask = $transaction->task;
        $task = Task::first();

        $this->assertTrue(
            $transactionTask->is($task)
        );
    }

    /** @test */
    public function has_one()
    {
        /** Type->Task */
        $type = TaskType::first();
        $typeTask = $type->task;
        $task = Task::first();

        $this->assertTrue(
            $typeTask->is($task)
        );
    }

    /** @test */
    public function has_many()
    {
        /** Type->Task */
        $type = TaskType::first();
        $typeTasks = $type->tasks;
        $tasks = Task::whereIn('id', [1,2])
            ->get();

        $this->assertEquals($typeTasks->count(), 2);
        $this->assertEquals($tasks->count(), 2);

        $typeTasks->each( function($typeTask, $index) use($tasks) {
            $this->assertTrue(
                $typeTask->is($tasks[$index])
            );
        });
    }

    /** @test */
    public function belongs_to()
    {
        /** Task->Type */
        $task = Task::first();
        $taskType = $task->type;
        $type = TaskType::first();

        $this->assertTrue(
            $taskType->is($type)
        );
    }

    /** @test */
    public function has_one_with_json()
    {
        /** Task->User */
        $task = Task::find(2);
        $taskUser = $task->assignee;
        $user = User::first();

        $this->assertTrue(
            $taskUser->is($user)
        );
    }

    /** @test */
    public function has_many_with_json()
    {
        /** Task->User */
        $task = Task::find(3);
        $taskUsers = $task->eligibleAssignees;
        $users = User::where('json_col->group', 'cash')
            ->get();

        $this->assertEquals($taskUsers->count(), 2);
        $this->assertEquals($users->count(), 2);
        
        $taskUsers->each( function($taskUser, $index) use($users) {
            $this->assertTrue(
                $taskUser->is($users[$index])
            );
        });
    }

    /** @test */
    public function belongs_to_with_json()
    {
        /** User->Task */
        $user = User::first();
        $userTask = $user->task;
        $task = Task::find(2);

        $this->assertTrue(
            $userTask->is($task)
        );
    }
}