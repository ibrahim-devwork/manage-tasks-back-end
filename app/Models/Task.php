<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = ['description', 'deadline', 'statut', 'id_project'];
    
    /*
    * Reatioships
    */
    public function tasks_users()
    {
        return $this->belongsToMany(User::class, 'tasks_users', 'id_task', 'id_user');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project', 'id');
    }

    /*
    * Scope for search
    */
    public function scopeSearch($query, $search)
    {
        return $query->where('description', 'LIKE', "%{$search}%");
    }
    

}
