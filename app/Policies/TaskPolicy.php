<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return mixed
     */
    public function update(User $user, Task $task)
    {
        return $this->isFromUserList($user,$task);
    }

    /**
     * Determines if the user is the owner of the list
     *
     * @param User     $user
     * @param Task $task
     *
     * @return bool
     */
    private function isFromUserList(User $user, Task $task): bool {
        return $user->is($task->list->user);
    }
}
