<?php


namespace App\Interfaces;


interface TaskControl
{
    public function enableTask(int $task_id): bool;

    public function disableTask(int $task_id): bool;

    public function finishTask(int $task_id): bool;

    public function reopenTask(int $task_id): bool;
}
