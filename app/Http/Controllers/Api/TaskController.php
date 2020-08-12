<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return response()->json($tasks);
    }

    public function show($task)
    {
        $task = Task::findOrFail($task);

        return response()->json($task);
    }
}
