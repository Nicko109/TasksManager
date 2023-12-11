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

    const STATUS_IN_PROGRESS = 0;
    const STATUS_IN_REVIEW = 1;
    const STATUS_IN_COMPLETED = 2;

    public function getStatus()
    {
        return [
        self::STATUS_IN_PROGRESS => 'В работе',
        self::STATUS_IN_REVIEW => 'На проверке',
        self::STATUS_IN_COMPLETED => 'Выполнено',
        ];
    }


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
