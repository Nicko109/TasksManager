<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = false;
    protected $withCount = ['comments'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class, 'task_id', 'id');
    }

}