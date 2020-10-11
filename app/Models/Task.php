<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property TodoList list
 * @property int      id
 * @property string   title
 * @property mixed    deadline
 * @property int      todo_list_id
 * @property boolean  disabled
 * @property boolean  ready
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'deadline', 'ready', 'disabled'
    ];

    public function  list()
    {
        return $this->belongsTo(TodoList::class, 'todo_list_id');
    }

    public function expired()
    {
        return new Carbon() > $this->deadline;
    }

    public function enable(){
       return $this->update(['disabled' => false]);
    }

    public function disable(){
        return $this->update(['disabled' => true]);
    }

    public function finish(){
        return  $this->update(['ready' => true]);
    }

    public function restart(){
        return  $this->update(['ready' => false]);
    }
}
