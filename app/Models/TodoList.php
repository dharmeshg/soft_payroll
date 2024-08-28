<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TodoList extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = ['todo_date'];
    protected $fillable = [
        'id',
        'todo_title',
        'todo_date',
        'completed_status',
        'user_id'
    ];

   
}
