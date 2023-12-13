<?php

namespace Modules\DocumentManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\UserManagement\app\Models\User;
use Modules\DocumentManagement\app\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\DocumentManagement\app\Models\DocumentRequest;
use Auth;

class DocumentRequestController extends Controller
{
    public function getDocumentRequests(){

        $userId = auth()->user()->id;
        $user = User::find($userId);
        $documentRequests = $user->documentRequests;
        return response()->json([
            "message" => "all request fetched",
            "requests" =>  $documentRequests
        ]);
    }

    public function sendDocumentRequest(Request $request)
    {
        $documentRequest = new DocumentRequest;
        $documentRequest->title = $request->title;
        //document request
        $documentRequest->request_from = $request->request_from;
        $documentRequest->request_to = $request->request_to[0];
        $documentRequest->request_status = $request->request_status;
        $documentRequest->document_id = $request->document_id;
        $documentRequest->treated_by = $request->treated_by;
        $documentRequest->remark = $request->remark;
        $documentRequest->document_ref = $request->document_ref;
        $documentRequest->save();
        if($request->request_to){
            $documentRequest->users()->attach($request->request_to);
        }
        return response()->json([
            "message" => "Document request sent",
            "documentRequest" => $documentRequest
        ]);
    }


    public function processDocumentRequest(Request $request, $id)
    {
        $documentRequest = DocumentRequest::find($id);
        if($documentRequest->id)
        {
            $documentRequest->treated_by= Auth::user()->id;
            $documentRequest->remark= $request->remark;
            $documentRequest->request_status = $request->request_status;
            $documentRequest->update();
            return response()->json([
                "message" => "document status update"
            ],201);
        }
    }

    public function viewDocumentRequest(DocumentRequest $documentRequest)
    {
        return $documentRequest;
    }

    public function retractDocumentRequest(){

    }


}
