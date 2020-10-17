<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    public Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    function list(): Collection
    {
        return $this->model->all();
    }

    function makeNew(array $fields): Model
    {
        return $this->model->create($fields);

    }

    function read(int $id): ?Model
    {
        return $this->model->findOrFail($id);
    }

    function change(array $fields, $model): Model
    {
        $this->model->update($fields);
        return $model;
    }

    function remove(array $ids): bool
    {
        return $this->model->destroy($ids);
    }
}
