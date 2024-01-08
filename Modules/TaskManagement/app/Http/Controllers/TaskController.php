<?php

namespace Modules\TaskManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\TaskManagement\app\Models\Task;
use Modules\DocumentManagement\app\Models\Document;
use Modules\UserManagement\app\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;
use Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getTasks()
    {
        $user = User::find(Auth::user()->id);
        $tasks = $user->tasks;
        //$tasks = Task::all();
        return response()->json([
            'message' => 'All task fetched',
            'tasks' => $tasks
        ]);
    } 

    public function getUserTasks(User $user)
    {
        $tasks = $user->tasks()->get();
        return response()->json([
            'message' => 'All task fetched',
            'tasks' => $tasks
        ]);
    } 
    public function getTaskUsers(Task $task)
    {
        $users = $task->users()->get();
        return response()->json([
            'message' => 'All task members fetched',
            'tasks' => $users
        ]);
    } 

    public function viewTask(Task $task)
    {
        return response()->json([
            "message" => "success",
            "task" => $task,
            'documents' => $task->documents,
            'members' => $task->users()->get(),
            'comments' => $task->comments()->get()
        ]);
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
            $task->created_by = Auth::user()->id;
            $task->type = $request->type;
            $task->user_id = $request->user_id;
            $task->status = $request->status;
            $task->save();
            // if($request->users == null){
                
            // }
            if($request->users){
                $this->assignMembers($request->users, $task);
            }
            
            return response()->json([
                "message" => "Task saved successfully.",
                'Created Task' => $task
            ],201);
        }
    }

    public function assignMembers($user, Task $task)
    {
        return $task->users()->attach($user);
    }
    
    public function updateTaskMembers()
    {

    }
    
    protected function removeTaskMember()
    {

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
            $task->type = is_null($request->type) ? $task->type : $request->type; 
            $task->status = is_null($request->status) ? $task->status : $request->status; 
            $task->update();
            return response()->json([
                "message" => "Task record updated"
            ],201);
        }
    }

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
