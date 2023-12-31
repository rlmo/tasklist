<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Date;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::whereDeleted(false)->get();

        return response()->json($tasks, 200);
    }

    public function store(TaskStoreRequest $request)
    {
        try
        {
            $task = Task::create($request->all());

            return response()->json(["Task Id {$task->id} created" => $task], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(["Error: {$e}"], 400);
        }
    }

    public function getTaskById($id)
    {
        $this->validateTaskId($id);

        try
        {
            $task = Task::find($id);

            if($task)
            {
                return response()->json($task, 200);
            }
            else
            {
                return response()->json(["Error" => "Task id '{$id}' not found"], 400);
            }
        }
        catch(\Exception $e)
        {
            return response()->json(["Error: {$e}"], 400);
        }
    }

    public function update($id, TaskUpdateRequest $request)
    {
        $this->validateTaskId($id);

        try
        {
            $task = Task::find($id);

            if($request->completed)
            {
                $task->completed_at = Date::now();
                $task->save();
            }
            
            Task::whereId($id)->update($request->all());

            return response()->json(["Task Id {$id} updated"], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(["Error: {$e}"], 400);
        }
    }

    public function delete($id)
    {
        $this->validateTaskId($id);

        try
        {
            $task = Task::find($id);

            if($task)
            {
                //$task->delete();
                $task->deleted = true;
                $task->deleted_at = Date::now();
                $task->save();

                return response()->json(["Task id '{$id}' deleted"], 200);
            }
            else
            {
                return response()->json(["Error" => "Task id '{$id}' not found"], 400);
            }
        }
        catch(\Exception $e)
        {
            return response("Error: {$e}", 400);
        }
    }

    private function validateTaskId($id)
    {
        if(!intval((int)$id))
            throw new HttpResponseException(response()->json(["Error" => "Id must be an integer, '{$id}' value given"], 400));
    }
}
