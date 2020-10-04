<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TodoListResource;
use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TodoList $todoList,  Task $task, TaskRequest $request)
    {
       if($request->filled('disabled')){
           $task->disabled = $request->get('disabled');
       }
       if($request->filled('ready') && !$task->disabled  && !$task->expired()){
           $task->ready = $request->get('ready');
       }
        if ($task->save()) {
            return response()->json(['message' => "$task->title was successfully updated", 'parent' => new TodoListResource($task->list)], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'task was not updated'], Response::HTTP_BAD_REQUEST);
        }

    }
}
