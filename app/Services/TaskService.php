<?php

namespace App\Services;


use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskService
{
    public static function index()
    {
        $user = Auth::user();

        $tasks = Task::where('user_id', $user->id)
            ->orWhere('performer_id', $user->id)
            ->get();

        return $tasks;
    }

    public static function store(array $data) : Task
    {
        if (isset($data['file'])) {
        $path = Storage::disk('public')->put('task' , $data['file']);
        $fullPath = Storage::disk('public')->url($path);
        $data['file'] = $fullPath;
        } else {
            unset($data['file']);
        }
        $data['user_id'] = auth()->user()->id;
        return Task::create($data);
    }





    public static function update(Task $task, array $data)
    {

        return $task->update($data);
    }

    public static function destroy(Task $task)
    {
        return $task->delete();
    }

    public static function updateFile(Task $task, array $data)
    {
        // Проверяем, предоставлен ли новый файл изображения
        if (isset($data['file']) && $data['file'] instanceof \Illuminate\Http\UploadedFile) {
            // Удаляем старое изображение
            Storage::disk('public')->delete($task->file);

            // Сохраняем новое изображение
            $path = Storage::disk('public')->put('task', $data['file']);
            $fullPath = Storage::disk('public')->url($path);
            $data['file'] = $fullPath;
        }

        // Возвращаем обновленные данные
        return $data;
    }


    public static function review(Task $task, array $data)
    {
        $task->status = 1;
        $task->update($data);

        return $task;
    }

    public static function complete(Task $task, array $data)
    {
        $task->status = 2;
        $task->update($data);

        return $task;
    }

    public static function work(Task $task, array $data)
    {
        $task->status = 0;
        $task->update($data);

        return $task;
    }

}
