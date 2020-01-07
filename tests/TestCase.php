<?php

namespace Tests;

use \Orchestra\Testbench\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

use Tests\Models\Position;
use Tests\Models\Task;
use Tests\Models\TaskType;
use Tests\Models\Transaction;
use Tests\Models\User;

abstract class TestCase extends BaseTestCase
{
    /**
     * Setup each test.
     *
     * @return void
    */
    protected function setUp(): void
    {
        parent::setUp();

        $this->migrate();
        $this->seed();
    }

    /**
     * Migrate the database.
     *
     * @return void
     */
    public function migrate()
    {
        Schema::dropAllTables();

        Schema::create('positions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('fund_id');
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id')->nullable();
            $table->unsignedInteger('fund_id')->nullable();
            $table->json('json_col')->nullable();
            $table->unsignedInteger('task_type_id')->nullable();
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->json('json_col')->nullable();
            $table->timestamps();
        });

        Schema::create('task_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->json('json_col')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Seed a given database connection.
     *
     * @param  string  $class
     * @return void
     */
    public function seed($class = 'DatabaseSeeder')
    {
        Model::unguard();

        // positions
        Position::create([
            'client_id' => 1,
            'fund_id' => 2,
        ]);
        Position::create([
            'client_id' => 1,
            'fund_id' => 2,
        ]);
        Position::create([
            'client_id' => 3,
            'fund_id' => 4,
        ]);

        // tasks
        Task::create([
            'client_id' => 1,
            'fund_id' => 2,
            'task_type_id' => 1,
        ]);
        Task::create([
            'client_id' => 3,
            'fund_id' => 4,
            'task_type_id' => 1,
            'json_col' => [
                'category' => 'dist',
                'type' => 'roc',
                'assignee' => 1,
            ],
        ]);
        Task::create([
            'json_col' => [
                'category' => 'dist',
                'type' => 'roc',
                'assignmentGroup' => 'cash',
            ],
            'task_type_id' => 2,
        ]);

        // transactions
        Transaction::create([
            'json_col' => [
                'category' => 'dist',
                'type' => 'roc',
            ],
        ]);
        Transaction::create([
            'json_col' => [
                'category' => 'dist',
                'type' => 'roc',
            ],
        ]);
        
        // task types
        TaskType::create([
            'name' => 'Transaction Discrepency',
        ]);

        // users
        User::create([
            'json_col' => [
                'group' => 'cash',
            ],
        ]);
        User::create([
            'json_col' => [
                'group' => 'cash',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('positions');
        Schema::drop('tasks');
        Schema::drop('task_types');
        Schema::drop('transactions');
    }
}
