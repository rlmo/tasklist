<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Throwable;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'completed' => 'required',
            'username' => 'required',
        ]);

        $task = Task::create($request->all());

        return response()->json(['task' => $task], 200);
    }

    public function getTaskById(int $id)
    {
        $task = Task::where('id' , '=' , $id)->first();

        if ($task)
        {
            return response()->json([
                'task' => $task
            ]);
        }
        else
        {
            return response()->json(['Error' => "Task id {$id} not found"], 400);
        }
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function delete($id)
    {
        $this->validateTaskId($id);

        try
        {
            $task = Task::find($id);

            if ($task)
            {
                $task->delete();
                return response()->json(['Status' => "Task id {$id} deleted"], 200);
            }
            else
            {
                return response()->json(['Error' => "Task id {$id} not found"], 400);
            }
        }
        catch (Throwable $e)
        {
            return response("Error: {$e}", 400);
        }
    }

    private function validateTaskId ($id)
    {
        if (!is_int($id))
            return response()->json(['Error' => "Id must be a number, '{$id}' value given"], 400);
        else
            echo "cool";
    }
}
