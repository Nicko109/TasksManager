<?php

namespace App\Http\Controllers\Main\Task;

use App\Http\Controllers\Controller;
use App\Http\Filters\TaskFilter;
use App\Http\Requests\Task\CommentRequest;
use App\Http\Requests\Task\FilterTaskRequest;
use App\Http\Requests\Task\IndexTaskRequest;
use App\Http\Requests\Task\ReviewTaskRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Task\TaskResource;
use App\Models\Comment;
use App\Models\LikedPost;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexTaskRequest $request)
    {
        $data = $request->validated();
        $filter = app()->make(TaskFilter::class, ['queryParams' => $data]);

        $tasks = Task::filter($filter)->get();



        $tasks->each(function ($task) {
            $task->formattedDeadline = $task->getFormattedDeadlineAttribute();
            $user = $task->user;
            $performer = $task->performer;
            $project = $task->project;
        });

        $isAdmin = auth()->user()->is_admin;


        return inertia('Task/Index', compact('tasks', 'isAdmin'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $users = User::all();
        $projects = auth()->user()->projects;
        return inertia('Task/Create', compact('users', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {

        $data = $request->validated();

        $task = TaskService::store($data);

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $isAdmin = auth()->user()->is_admin;
        $task->formattedDeadline = $task->getFormattedDeadlineAttribute();
        $user = $task->user;
        $performer = $task->performer;
        $project = $task->project;

        $isCustomer = auth()->user()->id === $task->user_id;
        $isPerformer = auth()->user()->id === $task->performer_id;

        return inertia('Task/Show', compact('task', 'isAdmin', 'user', 'performer', 'project', 'isCustomer', 'isPerformer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {

        $users = User::all();
        $projects = auth()->user()->projects;

        return inertia('Task/Edit', compact('task', 'users', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {

        $data = $request->validated();


        $data = TaskService::updateFile($task, $data);
        TaskService::update($task, $data);

        return redirect()->route('tasks.show', compact('task'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        TaskService::destroy($task);

        return redirect()->route('tasks.index');

    }


    public function comment(Task $task, CommentRequest $request)
    {
        $data = $request->validated();
        $data['task_id'] = $task->id;
        $data['user_id'] = auth()->id();

        $comment = Comment::create($data);

        return new CommentResource($comment);

    }

    public function commentList(Task $task)
    {
        $comments = $task->comments()->latest()->get();

        return CommentResource::collection($comments);
    }

    public function review(ReviewTaskRequest $request, Task $task)
    {
        $data = $request->validated();

        TaskService::review($task, $data);

        return $data;
    }

    public function complete(ReviewTaskRequest $request, Task $task)
    {
        $data = $request->validated();

        TaskService::complete($task, $data);

        return $data;
    }

    public function work(ReviewTaskRequest $request, Task $task)
    {
        $data = $request->validated();

        TaskService::work($task, $data);

        return $data;
    }

}
