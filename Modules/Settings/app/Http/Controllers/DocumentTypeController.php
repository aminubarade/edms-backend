<?php

namespace Modules\Settings\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Settings\app\Models\DocumentType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DocumentTypeController extends Controller
{
    public function getAllDocumentTypes()
    {
       $documentTypes = DocumentType::all();
       return response()->json([
        'message' => 'All DocumentTypes fetched',
        'DocumentTypes' => $documentTypes
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createDocumentType(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'documentType_name' => 'required'
        ]);
        if($validated->fails())
        {
            return response()->json([
                'message' => $validated->messages()
            ], 401);
        }
        else{
            $documentType = new DocumentType;
            $documentType->documentType_name = $request->documentType_name;
            $documentType->slug = Str::slug($documentType->documentType_name);
            $documentType->save();
            return response()->json([
                'message' => 'DocumentType created successfully',
                'DocumentType' => $documentType
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateDocumentType(Request $request, DocumentType $documentType)
    {
        if($documentType->slug)
        {
            $documentType->documentType_name= is_null($request->documentType_name) ? $documentType->documentType_name: $request->documentType_name; 
            $documentType->slug= is_null($request->documentType_name) ? $documentType->slug: Str::slug($documentType->documentType_name); 
            //$DocumentType->created_by = is_null($request->updated_by) ? $DocumentType->updated_by : $request->updated_by;
            $documentType->update();
            return response()->json([
                "message" => "DocumentType record updated"
            ],201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteDocumentType(DocumentType $documentType)
    {
        if($documentType->slug)
        {
            $documentType->delete();
            return response()->json([
                "message" => "DocumentType Deleted"
            ], 200);
        }else 
        {
            return response()->json([
                "message" => "DocumentType Not Found"
            ],404);
        }
    }
}
