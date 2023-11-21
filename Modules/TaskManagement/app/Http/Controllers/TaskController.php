<?php

namespace Modules\TaskManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\TaskManagement\app\Models\Task;
use Modules\UserManagement\app\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getTasks()
    {
        $tasks = Task::all();//where task$task id = created by or task$task ID in members
        return response()->json([
            'message' => 'All task fetched',
            'tasks' => $tasks
        ]);
    } 

        /**
     * Show the specified resource.
     */
    public function viewTask(Task $task)
    {
        return $task;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeTask(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'task_title' => 'required|unique:tasks|max:255',
            'type' => 'required',
        ]);

        if($validated->fails()){
            return response()->json([
                "status" => 422,
                "message" => $validated->messages()
            ],422);
        }else{
            $task = new Task;
            $task->task_title = $request->task_title;
            $task->slug = Str::slug($task->task_title);
            $task->description = $request->description;
            $task->created_by = $request->created_by;
            $task->type = $request->type;
            $task->status = $request->status;
            $task->save();
            // if($request->users == null){
                
            // }
            $this->assignMembers($request->users, $task);
            return response()->json([
                "message" => "Task saved successfully.",
                'Created Task' => $task
            ],201);
        }
    }

    public function assignMembers($user, Task $task){
        return $task->users()->attach($user);
    }
    
    public function updateTaskMembers(){

    }
    protected function removeTaskMember(){

    }

    /**
     * Update the specified resource in storage.
     */
    public function updateTask(Request $request, Task $task)
    {
        //
        if($task->slug)
        {
            $task->task_title= is_null($request->task_title) ? $task->task_title: $request->task_title; 
            $task->slug= is_null($request->task_title) ? $task->slug: Str::slug($task->task_title); 
            $task->description = is_null($request->description) ? $task->description: $request->description; 
            $task->created_by = is_null($request->created_by) ? $task->created_by : $request->created_by; 
            $task->members = is_null($request->members) ? $task->members : $request->members; 
            $task->type = is_null($request->type) ? $task->type : $request->type; 
            $task->status = is_null($request->status) ? $task->status : $request->status; 
            $task->update();
            return response()->json([
                "message" => "Task record updated"
            ],201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteTask(Task $task)
    {
        //
        if($task->slug)
        {
            $task->delete();
            return response()->json([
                "message" => "Task Deleted"
            ], 200);
        }else 
        {
            return response()->json([
                "message" => "Task Not Found"
            ],404);
        }
    }
}
