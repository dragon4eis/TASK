<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoListRequest;
use App\Http\Resources\TodoListResource;
use App\Models\TodoList;
use App\Repositories\TodoListRepository;
use App\Repositories\TodoListRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

final class TodoListController extends Controller
{
    protected TodoListRepositoryInterface $listRepository;

    public function __construct(TodoListRepositoryInterface $repository)
    {
        $this->authorizeResource(TodoList::class, 'todoList');

        $this->listRepository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index()
    {
        return TodoListResource::collection($this->listRepository->list());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TodoListRequest $request
     *
     * @return JsonResponse|Response
     */
    public function store(TodoListRequest $request)
    {
        if ($todoList = $this->listRepository->makeNew($request->all())) {
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
     * @param TodoList $todoList
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
     * @param Request $request
     * @param TodoList                 $todoList
     *
     * @return JsonResponse
     */
    public function update(TodoListRequest $request, TodoList $todoList)
    {
        if ($todoList = $this->listRepository->change($request->all(), $todoList)) {
            return response()->json(['message' => "$todoList->title was successfully updated", 'resource' => new TodoListResource($todoList)], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'List was not updated'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TodoList $todoList
     *
     * @return JsonResponse|Response
     */
    public function destroy(TodoList $todoList)
    {
        try {
            if ($this->listRepository->remove(Arr::wrap($todoList->id))) {
                return response()->json(['message' => "$todoList->title was successfully removed"], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'List was not removed'], Response::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            Log::critical($e);
            return response()->json(['message' => 'List not removed, try again later.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
