<?php

namespace App\Policies;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoListPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
       return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TodoList  $todoList
     * @return mixed
     */
    public function view(User $user, TodoList $todoList)
    {
        return $this->userOwnList($user,$todoList);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TodoList  $todoList
     * @return mixed
     */
    public function update(User $user, TodoList $todoList)
    {
        return $this->userOwnList($user,$todoList);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TodoList  $todoList
     * @return mixed
     */
    public function delete(User $user, TodoList $todoList)
    {
        return $this->userOwnList($user,$todoList);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TodoList  $todoList
     * @return mixed
     */
    public function restore(User $user, TodoList $todoList)
    {
        return $this->userOwnList($user,$todoList);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TodoList  $todoList
     * @return mixed
     */
    public function forceDelete(User $user, TodoList $todoList)
    {
        return $this->userOwnList($user,$todoList);
    }

    /**
     * Determines if the user is the owner of the  list
     *
     * @param User     $user
     * @param TodoList $todoList
     *
     * @return bool
     */
    private function userOwnList(User $user, TodoList $todoList): bool {
        return $user->is($todoList->user);
    }
}
