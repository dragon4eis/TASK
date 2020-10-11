<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TodoListResource;
use App\Models\Task;
use App\Services\TaskControlService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DisabledTaskController extends Controller
{
    protected  $taskControl;

    public function __construct(TaskControlService $service)
    {
        $this->taskControl = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if($this->taskControl->disableTask($id = $request->get('task_id'))){
            return response()->json(['message' => "Task was disabled" ,  'parent' =>  new TodoListResource(Task::findOrFail($id)->list)], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'List was not saved'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        if($this->taskControl->enableTask($id)){
            return response()->json(['message' => "Task was successfully enabled",  'parent' =>  new TodoListResource(Task::findOrFail($id)->list)], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'List was not saved'], Response::HTTP_BAD_REQUEST);
        }
    }
}
