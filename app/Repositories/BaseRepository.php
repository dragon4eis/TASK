<?php


namespace App\Repositories;


use App\Models\TodoList;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseRepository implements BaseRepositoryInterface
{
    public Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    function list(): Collection
    {
        return Auth::user()->todoLists;
    }

    function makeNew(array $fields): Model
    {
        $list = TodoList::create([
            'title' => $fields['title'],
            'user_id' => Auth::user()->getAuthIdentifier(),
        ]);
        $list->tasks()->createMany($fields['tasks']);
        return $list->refresh();

    }

    function read(int $id): Model
    {
        return TodoList::findOrFail($id);
    }

    function change(array $fields, $model): Model
    {
        $model->update($fields);
        $model->tasks()->delete();
        $model->tasks()->createMany($fields['tasks']);
        return $model;
    }

    function remove($model): bool
    {
        return $model->delete();
    }
}
