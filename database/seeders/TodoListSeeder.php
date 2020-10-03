<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Database\Seeder;

class TodoListSeeder extends Seeder
{
    private $limiter;

    public function __construct( $maxFakeLists = 5)
    {
        $this->limiter =  $maxFakeLists ;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//        TodoList::factory()
//            ->times($this->limiter)
//            ->createChildren()

        foreach (User::all() as $user){
            for ($i = 0; $i < $this->limiter; $i++){
                $list = TodoList::factory()->make();
                $list->user()->associate($user);
                $list->save();
                for ($j = 0; $j < $this->limiter; $j++){
                    $task = Task::factory()->make();
                    $task->list()->associate($list);
                    $task->save();
                }
            }
        }
    }
}
