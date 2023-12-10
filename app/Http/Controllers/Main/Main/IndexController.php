<?php

namespace App\Http\Controllers\Main\Main;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $isAdmin = auth()->user()->is_admin;

        return inertia('Main', compact('isAdmin'));
    }
}
