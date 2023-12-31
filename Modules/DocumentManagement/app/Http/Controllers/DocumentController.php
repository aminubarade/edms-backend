<?php

namespace Modules\DocumentManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\taskManagement\app\Models\Task;
use Modules\UserManagement\app\Models\User;
use Modules\DocumentManagement\app\Models\Document;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\FileUploads;
use Illuminate\Support\Str;
use Auth;
use DB;

class DocumentController extends Controller
{
    use FileUploads;
    const DOCUMENT_REFERENCE_CODE_PREFIX = 'NHQ/08/VOL-';

    public function getDocuments()
    {
        $user = User::find(Auth::user()->id);
        $documents = $user->documents;
        return response()->json([
            'message' => 'All Documents fetched',
            'documents' => $documents
        ]);
    }

    public function saveDocument(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'document_title' => 'required|unique:documents|max:255',
            'type' => 'required',
        ]);

        if($validated->fails())
        {
            return response()->json([
                "status" => 422,
                "message" => $validated->messages()
        ],422);
        }
        else{
            $document = new Document;
            $document->document_title = $request->document_title;
            $document->slug = Str::slug($document->document_title);
            $document->type = $request->type;
            $document->classification = $request->classification;
            $document->body = $request->body;
            $document->created_by = Auth::user()->id;
            $document->task_id = $request->task_id;
            $document->folder_id = $request->folder_id; 
            $document->department_id = $request->department_id;
            $document->save();
            if(!$document->document_ref){
                $this->generateUserRefCode($document);
            }
            if($request->users){
                $document->users()->attach($request->users); 
            }
            // if($request->files){
            //     $this->attachFileToDocument($request, $document);
            // }

            //$this->attachFileToDocument($request, $id);
            return response()->json([
                "message" => "Document created successfully.",
                'Created document' => $document 
            ],201);
        }
    }

    public function viewDocument(Document $document)
    {
        $user = User::find($document->created_by);
        return response()->json([
            'message' => 'viewing document',
            'document' => $document,
            'created_by'=> $user->username,
            'members' => $document->users()->get(),
            'comments' => $document->comments()->get()
        ]);
    }

    public function updateDocument(Request $request, Document $document)
    {
        if($document->slug || $document->is_active = 1)
        {
            $document->document_title= is_null($request->document_title) ? $document->document_title: $request->document_title; 
            $document->slug= is_null($request->document_title) ? $document->slug: Str::slug($document->document_title); 
            $document->type = is_null($request->type) ? $document->type : $request->type; 
            $document->classification = is_null($request->classification) ? $document->classification : $request->classification; 
            $document->body = is_null($request->body) ? $document->body: $request->body; 
            $document->updated_by = Auth::user()->id;
            //remove update member
            $document->update();
            return response()->json([
                "message" => "document record updated",
                "document" => $document
            ],201);
        }
    }

    public function deleteDocument(Document $document)
    {
        //
        if($document->slug)
        {
            $document->users()->detach();
            $document->delete();
            return response()->json([
                "message" => "Document Deleted"
            ], 200);
        }else 
        {
            return response()->json([
                "message" => "Document Not Found"
            ],404);
        }
    }

    public function completeDocument(Request $request, Document $document)
    {
        if($document->slug)
        {
            $document->completed_by = auth()->user()->id;
            $document->status = $request->status;
            if($document->status = 'complete'){$document->is_active = 0;}
            $document->update();
            return response()->json([
                "message" => "document status update"
            ],201);
        }
    }

    public function shareDocument(Request $request, Document $documents)
    {
         $document->users()->attach($request->users);
         return response()->json([
            "message" => "Shared with",
            'members' => $document->users()->get()
         ]);
    }

    public function addDocumentToTask(Document $document)
    {
        if($document->slug){
            $document->task_id = $request->task_id;
            $document->update();
        }
        return response()->json([
            "message" => "Document added to task successfully",
            'document' => $document
        ]);
    }

    public function moveDocumentToFolder()
    {
        if($document->slug){
            $document->folder_id = $request->folder_id;
            $document->update();
        }
        return response()->json([
            "message" => "Document added to folder successfully",
            'document' => $document
        ]);
    }

    public function attachFileToDocument(Request $request, $id)
    {
        $entity = Document::find($id);
        if(!$entity){
            return response()->json([
                "message" => "Entity Not Found"
        ],422);
        }
        $this->uploadFile($request, $entity);
        return response()->json([
            "message" => "success"
        ], 200);
    }

    public function searchDocument(Request $request)
    {
        $documents = Document::latest();
        if($request->search){
            $documents
            ->where('title', 'like', '%'.$request->search.'%')
            ->orWhere('body', 'like', '%'.$request->search.'%');
        }
        return response()->json([
            'message' => 'Search result',
            'documents' => $documents->get()
        ]);
    }

    private function generateUserRefCode(Document $document)
    {
        $baseValue = 0;
        $incrementId = $baseValue + $document->id;
        $document->document_ref=  self::DOCUMENT_REFERENCE_CODE_PREFIX.$incrementId;
        $document->save();
    }
}
