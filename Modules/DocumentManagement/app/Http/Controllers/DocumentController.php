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
            $document->body = $request->body;
            $document->status = $request->status; 
            $document->user_id = $request->created_by;
            $document->approved_by = $request->approved_by;
            //document
            $document->save();
            return response()->json([
                "message" => "document created successfully.",
                'Created document' => $document
            ],201);
        }
    }

    public function viewDocument(Document $document)
    {
        return $document;
    }


    protected function approveDocument(Request $request, Document $document)
    {
        
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
            $document->status = is_null($request->status) ? $document->status : $request->status;
            //approval status
            $document->user_id = is_null($request->created_by) ? $document->user_id : $request->created_by; 
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
