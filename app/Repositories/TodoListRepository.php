<?php


namespace App\Repositories;


use App\Models\TodoList;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

final class TodoListRepository extends BaseRepository implements BaseRepositoryInterface
{
    public function __construct(TodoList $model)
    {
        parent::__construct($model);
    }

    public function list(): Collection
    {
        return Auth::user()->todoLists;
    }

    public function makeNew(array $fields): Model
    {
        $fields['user_id'] = Auth::user()->getAuthIdentifier();
        $list = parent::makeNew($fields);
        $list->tasks()->createMany($fields['tasks']);
        return $list->refresh();
    }

    public function change(array $fields, $model): Model
    {
        $list = parent::change($fields, $model);
        $list->tasks()->delete();
        $list->tasks()->createMany($fields['tasks']);
        return $list;
    }
}
