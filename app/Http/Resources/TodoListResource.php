<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TodoListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $tasks = TaskResource::collection($this->tasks);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'tasks' => $tasks->sortBy('id')->toArray(),
            'ready' => count($this->tasks) === $tasks->where('ready', true)->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
