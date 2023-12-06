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
use Illuminate\Support\Str;
use DB;

class DocumentController extends Controller
{
    public function getDocuments()
    {
        $documents = Document::all();//where document$document id = created by or document$document ID in classification
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
            $document = new document;
            $document->document_title = $request->document_title;
            $document->slug = Str::slug($document->document_title);
            $document->type = $request->type;
            $document->classification = $request->classification;
            $document->document_ref = $request->document_ref;
            $document->body = $request->body;
            $document->status = $request->status;
            $document->created_by = $request->created_by;
            $document->approved_by = $request->approved_by;
            $document->task_id = $request->task_id;
            $document->folder_id = $request->folder_id;
            $document->department_id = $request->department_id;
            $document->save();
            if($request->users){
                $document->users()->attach($request->users); 
            }
            return response()->json([
                "message" => "Document created successfully.",
                'Created document' => $document
            ],201);
        }
    }

    public function viewDocument(Document $document)
    {
        return response()->json([
            'message' => 'viewing document',
            'document' => $document,
            'members' => $document->users()->get()
        ]);
    }

    protected function approveDocument(Request $request, Document $document)
    {
        if($document->slug)
        {
            $document->approved_by = is_null($request->approved_by) ? $document->approved_by : $request->approved_by;
            $document->status = is_null($request->status) ? $document->status : $request->status;
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
            'members' => $document->users()
         ]);
    }


    public function updateDocument(Request $request, Document $document)
    {
        if($document->slug)
        {
            $document->document_title= is_null($request->document_title) ? $document->document_title: $request->document_title; 
            $document->slug= is_null($request->document_title) ? $document->slug: Str::slug($document->document_title); 
            $document->type = is_null($request->type) ? $document->type : $request->type; 
            $document->classification = is_null($request->classification) ? $document->classification : $request->classification; 
            $document->body = is_null($request->body) ? $document->body: $request->body; 
            //approval status
            $document->created_id = is_null($request->created_by) ? $document->created_by : $request->created_by; 
            $document->approved_by = is_null($request->approved_by) ? $document->approved_by : $request->approved_by;
            $document->update();
            return response()->json([
                "message" => "document record updated"
            ],201);
        }
    }

    public function deleteDocument(Document $document)
    {
        //
        if($document->slug)
        {
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
}
