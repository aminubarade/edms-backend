<?php

namespace Modules\UserManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\UserManagement\app\Models\Comment;
use Modules\DocumentManagement\app\Models\Document;
use Modules\TaskManagement\app\Models\Task;
use Modules\UserManagement\app\Models\User;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private function getAllComments()
    {
        $comments = Comment::all();
        return response()->json([
            'message' => 'All Task comments fetched',
            'comments' => $comments
            ]
        );
    }


    public function getUserComments(User $user){
        return response()->json([
            'message' => 'Tasks comments fetched',
            'task_comments' => $user->comments
        ]);
    }

    public function getTaskComments(Task $task){
        return response()->json([
            'message' => 'Tasks comments fetched',
            'task_comments' => $task->comments
        ]);
    }

    public function getDocumentComments(Document $document){
        return response()->json([
            'message' => 'Document comments fetched',
            'task_comments' => $document->comments
        ]);
    }
    
    public function addComment(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'body' => 'required|unique:comments|max:255',
        ]);

        if($validated->fails()){
            return response()->json([
                "status" => 422,
                "message" => $validated->messages()
            ],422);
        }
        else
        {
            $comment = new Comment;
            $comment->body = $request->body;
            $comment->user_id = $request->user_id;
            $comment->task_id = $request->task_id;
            $comment->document_id = $request->document_id;
            $comment->save();
            return response()->json([
                "message" => "Comment added",
                'comment' => $comment
            ],201);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(Comment $comment)
    {
        return $comment;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
