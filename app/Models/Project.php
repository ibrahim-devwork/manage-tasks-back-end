<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = ['name', 'description', 'id_user'];

    /*
    * Reationships
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    /*
    * Scope for search
    */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', "%{$search}%");
    }
}
