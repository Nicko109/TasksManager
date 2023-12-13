<?php

namespace App\Http\Controllers\Main\Task;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;


class FilterListController extends Controller
{
   public function filter(Task $task)
   {
       $statuses = $task->getStatus();
       $projects = Project::all();

       $result = [
           'statuses' => $statuses ,
           'projects' => $projects ,
       ];

       return response()->json($result);
   }

}
