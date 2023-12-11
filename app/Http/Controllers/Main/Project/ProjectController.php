<?php

namespace App\Http\Controllers\Main\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\ProjectComment;
use App\Models\User;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Not;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $this->authorize('viewAny', Project::class);

        $projects = ProjectService::index();



        $projects->each(function ($project) {
            $user = $project->user;
            $performer = $project->performer;
        });
        $isAdmin = auth()->user()->is_admin;

        return inertia('Project/Index', compact('projects', 'isAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $users = User::all();
        return inertia('Project/Create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {

        $data = $request->validated();

        $project = ProjectService::store($data);

        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $user = $project->user;
        $performer = $project->performer;

        $isAdmin = auth()->user()->is_admin;


        return inertia('Project/Show', compact('project', 'isAdmin', 'performer', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {

        $users = User::all();

        return inertia('Project/Edit', compact('project', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        $data = $request->validated();
        ProjectService::update($project, $data);

        return redirect()->route('projects.show', compact('project'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        ProjectService::destroy($project);

        return redirect()->route('projects.index');

    }


}
