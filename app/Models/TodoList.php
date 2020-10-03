<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property User   user
 * @property array  tasks
 * @property string title
 * @property int    user_id
 * @property int  id
 */
class TodoList extends Model
{
    use HasFactory;

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
