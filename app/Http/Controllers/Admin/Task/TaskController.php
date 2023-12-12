<?php

namespace App\Http\Controllers\Admin\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\FilterTaskRequest;
use App\Http\Requests\Task\ReviewTaskRequest;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mockery\Matcher\Not;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FilterTaskRequest $request)
    {
        $data = $request->validated();

        $status = $request->input('status');

        $tasks = Task::latest();

        if ($status) {
            if ($status == 'in_progress') {
                $tasks->where('status', 0);
            } elseif ($status == 'in_review') {
                $tasks->where('status', 1);
            } elseif ($status == 'completed') {
                $tasks->where('status', 2);
            }
        }

        $tasks = $tasks->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $projects = Project::all();
        return view('tasks.create', compact('users', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();

        $task = TaskService::store($data);

        return redirect()->route('admin.tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $users = User::all();
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'users', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $data = $request->validated();

        $data = TaskService::updateFile($task, $data);


        TaskService::update($task, $data);

        return redirect()->route('admin.tasks.show', compact('task'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        TaskService::destroy($task);

        return redirect()->route('admin.tasks.index');

    }


    public function review(ReviewTaskRequest $request, Task $task)
    {
        $data = $request->validated();

        TaskService::review($task, $data);

        return redirect()->route('admin.tasks.show', compact('task'));
    }

    public function complete(ReviewTaskRequest $request, Task $task)
    {
        $data = $request->validated();

        TaskService::complete($task, $data);

        return redirect()->route('admin.tasks.show', compact('task'));
    }

    public function work(ReviewTaskRequest $request, Task $task)
    {
        $data = $request->validated();

        TaskService::work($task, $data);

        return redirect()->route('admin.tasks.show', compact('task'));
    }

}
