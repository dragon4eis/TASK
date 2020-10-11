<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoListRequest;
use App\Http\Resources\TodoListResource;
use App\Models\TodoList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TodoListController extends Controller
{
    protected $todoList;
    public function __construct(TodoList  $list)
    {
        $this->authorizeResource(TodoList::class, 'todoList');
        $this->todoList = $list;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index()
    {
        return TodoListResource::collection($this->todoList->list());
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
        if ($todoList = $this->todoList->makeNew($request->all())) {
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
        if ($todoList = $this->todoList->change($request->all(), $todoList)) {
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
            if ($this->todoList->remove($todoList)) {
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
