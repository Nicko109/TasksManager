<?php

namespace App\Http\Controllers\Admin\Comment;

use App\Http\Controllers\Admin\Task\TaskController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Requests\Task\CommentRequest;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\ProjectService;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $comments = Comment::all();

        return view('comments.index', compact('comments'));
    }

    public function create()
    {
        $users = User::all();
        $tasks = Task::all();
        return view('comments.create', compact('users', 'tasks'));
    }

    public function store(CommentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        Comment::create($data);

        return redirect()->route('admin.comments.index');
    }

    public function show(Comment $comment)
    {
        return view('comments.show', compact('comment'));
    }

    public function edit(Comment $comment)
    {
        $tasks = Task::all();

        return view('comments.edit', compact('comment', 'tasks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $data = $request->validated();
        $comment->update($data);

        return redirect()->route('admin.comments.show', compact('comment'));

    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('admin.comments.index');

    }
}
