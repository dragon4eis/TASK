<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoListRequest;
use App\Http\Resources\TodoListResource;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TodoListController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TodoList::class, 'todoList');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return TodoListResource::collection(Auth::user()->todoLists);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(TodoListRequest $request)
    {
        $todoList = new TodoList();
        $todoList->title = $request->get('title');
        $todoList->user_id = Auth::user()->getAuthIdentifier();
        if ($todoList->save()) {
            $todoList->tasks()->createMany($request->get('tasks'));
            return response()->json(['message' => "$todoList->title was successfully created", 'resource' => new TodoListResource($todoList)],
                Response::HTTP_CREATED,
                ['Location' => route('todoList.show', ['todoList' => $todoList->id])]);
        } else {
            return response()->json(['message' => 'List was not saved'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\TodoList $todoList
     *
     * @return TodoListResource
     */
    public function show(TodoList $todoList)
    {
        return new TodoListResource($todoList);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TodoList     $todoList
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TodoListRequest $request, TodoList $todoList)
    {
        $todoList->title = $request->get('title');
        $todoList->tasks()->delete();
        $todoList->tasks()->createMany($request->get('tasks'));
        if ($todoList->save()) {
            return response()->json(['message' => "$todoList->title was successfully updated", 'resource' => new TodoListResource($todoList)], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'List was not updated'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\TodoList $todoList
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy(TodoList $todoList)
    {
        try {
            if ($todoList->delete()) {
                return response()->json(['message' => "$todoList->title was successfully removed"], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'List was not removed'], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            Log::critical($e);
            return response()->json(['message' => 'List not removed, try again later.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
