<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TasksUser extends Model
{
    use HasFactory;

    protected $table = 'tasks_users';

    protected $fillable = ['id_user', 'id_task'];

}
