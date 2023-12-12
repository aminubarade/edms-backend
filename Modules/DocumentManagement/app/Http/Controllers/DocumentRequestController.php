<?php

namespace Modules\DocumentManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\DocumentManagement\app\Models\DocumentRequest;

class DocumentRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getRequest(){
        $documentRequests = DocumenntRequest::all();
        $currentUser = auth()->user()->id;
        if($user->id === $currentUser){
            $documentRequests = $user->documentRequest;
        }

        return response()->json([
            "message" => "all request fetched",
            "requests" =>  $documentRequests //$user->documentRequests
        ]);
    }

    public function sendRequest(Request $request)
    {
        $documentRequest = new DocumentRequest;
        $documentRequest->document_id = "request->document_id";
        //$documentRequest->title = $document->title;
        $documentRequest->request_from = $request->request_from;//user_id
        $documentRequest->request_to = $request->request_to;//user_id
        $documentRequest->request_status = $request->request_status;
        $documentRequest->treated_by = $request->treated_by;
        $documentRequest->remark = $request->remark;
        $documentRequest->document_ref = $request->document_ref;//doc()->id;
    }

    public function treatRequest(Request $request, $id)
    {
        $documentRequest = DocumentRequest::find($id);
        if($documentRequest->id)
        {
            $documentRequest->treated_by= is_null($request->treated_by) ? $documentRequest->treated_by: $request->treated_by;
            $documentRequest->remark= is_null($request->remark) ? $documentRequest->remark: $request->remark;
            $documentRequest->request_status = is_null($request->request_status) ? $documentRequest->request_status : $request->request_status;
            $documentRequest->update();
            return response()->json([
                "message" => "document status update"
            ],201);
        }
    }

    public function viewRequest(DocumentRequest $documentRequest)
    {
        return $documentRequest;
    }


}
