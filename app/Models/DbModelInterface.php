<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface DbModelInterface
{
    /**
     * Fully lists a  resource
     *
     * @return Collection
     */
    function list(): Collection;

    /**
     * Create new resource in the DB
     *
     * @param array $fields
     *
     * @return Model
     */
    function makeNew(array $fields): Model;

    /**
     * Reads the resource from dabase
     *
     * @param int $id
     *
     * @return Model
     */
    function read(int $id): ?Model;

    /**
     * Update resource
     *
     * @param array $fields
     *
     * @param Model $model
     *
     * @return Model
     */
    function change(array $fields, Model $model): Model;

    /**
     * Remove resource from database
     *
     * @param array $ids
     *
     * @return bool
     */
    function remove(array $ids): bool;
}
