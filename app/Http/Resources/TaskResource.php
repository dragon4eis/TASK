<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'todo_list_id' =>$this->todo_list_id,
            'title' => $this->title,
            'deadline' => $this->deadline,
            'disabled' => $this->disabled,
            'ready' => $this->ready,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
//            'expired' => $this->expired()
        ];
    }
}
