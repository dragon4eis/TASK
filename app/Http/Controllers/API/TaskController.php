<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(TodoList $todoList)
    {
        return TaskResource::collection($todoList->tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TodoList    $todoList
     * @param TaskRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function store(TodoList $todoList, TaskRequest $request)
    {
        $task = new Task();
        $task->title = $request->get('title');
        $task->deadline = $request->get('deadline');
        $task->todo_list_id = $todoList->id;
        $task->disabled = $request->get('disabled');
        if($task->save()){
            return response()->json(['message' => "$task->title was successfully created"], Response::HTTP_CREATED);
        } else {
            return response()->json(['message' => 'task was not saved'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     *
     * @return TaskResource
     */
    public function show(TodoList $todoList, Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TaskRequest $request, Task $task)
    {
       if($request->filled('disabled')){
           $task->disabled = $request->get('disabled');
       }
       if($request->filled('ready') && !$task->disabled  && !$task->expired()){
           $task->expired = $request->get('expired');
       }

        if ($task->save()) {
            return response()->json(['message' => "$task->title was successfully updated"], Response::HTTP_CREATED);
        } else {
            return response()->json(['message' => 'task was not updated'], Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     *
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function destroy(Task $task)
    {
        try {
            if ($task->delete()) {
                return response()->json(['message' => "$task->title was successfully removed"], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Task was not removed'], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            Log::critical($e);
            return response()->json(['message' => 'Task not removed, try again later.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
