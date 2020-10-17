<?php


namespace App\Services;

use App\Models\Task;

/**
 * Used for controlling tasks
 * Class TaskControlService
 * @package App\Services
 */
class TaskControlService implements TaskControl
{

    public function enableTask(int $task_id): bool{
        $task = Task::findOrFail($task_id);
        return $task->enable();
    }

    public function disableTask(int $task_id): bool
    {
        $task = Task::findOrFail($task_id);
        return $task->disable();
    }

    public function finishTask(int $task_id): bool
    {
        $task = Task::findOrFail($task_id);
        return $task->finish();
    }

    public function reopenTask(int $task_id): bool
    {
        $task = Task::findOrFail($task_id);
        return $task->restart();
    }
}
