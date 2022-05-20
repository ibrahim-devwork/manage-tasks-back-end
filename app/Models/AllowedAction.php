<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllowedAction extends Model
{
    use HasFactory;

    protected $table = 'allowed_actions';

    protected $fillable = ['id_user', 'id_action'];
}
