<?php

namespace App\Services;

use App\Models\LikedNote;
use App\Models\LikedPost;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectService
{
    public static function index()
    {
        $projects = Project::latest()->get();

        return $projects;
    }




    public static function store(array $data) : Project
    {
        $data['user_id'] = auth()->user()->id;
        return Project::create($data);
    }




    public static function update(Project $project, array $data)
    {

        return $project->update($data);
    }

    public static function destroy(Project $project)
    {
        return $project->delete();
    }
}
