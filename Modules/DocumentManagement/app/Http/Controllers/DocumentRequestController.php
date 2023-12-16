<?php

namespace Modules\DocumentManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\UserManagement\app\Models\User;
use Modules\DocumentManagement\app\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\DocumentManagement\app\Models\DocumentRequest;
use Illuminate\Support\Str;
use Auth;

class DocumentRequestController extends Controller
{
    public function getDocumentRequests()
    {
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
        $documentRequest->slug = Str::slug($documentRequest->title);//new
        $documentRequest->request_from = $request->request_from;
        if($documentRequest->request_from == Auth::user()->id){$documentRequest->is_active = 1;}//is active new
        $documentRequest->request_to = $request->request_to;
        $documentRequest->request_status = $request->request_status;
        $documentRequest->document_id = $request->document_id;
        $documentRequest->treated_by = $request->treated_by;
        $documentRequest->originated_by = Auth::user()->id;//new
        $documentRequest->remark = $request->remark;
        $documentRequest->document_ref = $request->document_ref;
        $documentRequest->save();
        if($request->copies){
            $members = $request->copies;
            array_push($members, $request->request_to);
        }
        else{
            $members = [$request->request_to];
        }
        $documentRequest->users()->attach(array_unique($members));
        return response()->json([
            "message" => "Document request sent",
            "documentRequest" => $documentRequest
        ]);
    }

    public function approveSendDocumentRequest(DocumentRequest $documentRequest)
    {
        if($request->request_from === Auth::user()->id){
            $documentRequest->is_active = $request->is_active;
            $documentRequest->update();
        }
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

    public function retractDocumentRequest()
    {

    }


}
