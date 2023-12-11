<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = false;
    protected $withCount = ['comments'];



    public function project(){

        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performer_id', 'id');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class, 'task_id', 'id');
    }

    public function getFormattedDeadlineAttribute()
    {
        return Carbon::parse($this->deadline)->format('d.m.y H:i');
    }

}
