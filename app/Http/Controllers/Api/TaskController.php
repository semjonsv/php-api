<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Task;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * Task index function
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = Task::all();

        return response()->json($tasks);
    }

    /**
     * Show task function
     *
     * @param integer $task
     * @return JsonResponse
     */
    public function show(int $task): JsonResponse
    {
        $task = Task::findOrFail($task);

        return response()->json($task);
    }
}
