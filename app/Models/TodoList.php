<?php

namespace App\Models;

use App\Http\Resources\TodoListResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @property User   user
 * @property array  tasks
 * @property string title
 * @property int    user_id
 * @property int    id
 */
class TodoList extends Model implements DbModelInterface
{
    use HasFactory;

    protected $fillable = [
        'title', 'user_id'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
