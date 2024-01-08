<?php

namespace Modules\Settings\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Settings\app\Models\DocumentClass;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DocumentClassController extends Controller
{
    public function getAllDocumentClasses()
    {
       $DocumentClasses = DocumentClass::all();
       return response()->json([
        'message' => 'All DocumentClasses fetched',
        'DocumentClasses' => $DocumentClasses
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createDocumentClass(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'DocumentClass_name' => 'required'
        ]);
        if($validated->fails())
        {
            return response()->json([
                'message' => $validated->messages()
            ], 401);
        }
        else{
            $DocumentClass = new DocumentClass;
            $DocumentClass->DocumentClass_name = $request->DocumentClass_name;
            $DocumentClass->slug = Str::slug($DocumentClass->DocumentClass_name);
            $DocumentClass->save();
            return response()->json([
                'message' => 'DocumentClass created successfully',
                'DocumentClass' => $DocumentClass
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateDocumentClass(Request $request, DocumentClass $DocumentClass)
    {
        if($DocumentClass->slug)
        {
            $DocumentClass->DocumentClass_name= is_null($request->DocumentClass_name) ? $DocumentClass->DocumentClass_name: $request->DocumentClass_name; 
            $DocumentClass->slug= is_null($request->DocumentClass_name) ? $DocumentClass->slug: Str::slug($DocumentClass->DocumentClass_name); 
            //$DocumentClass->created_by = is_null($request->updated_by) ? $DocumentClass->updated_by : $request->updated_by;
            $DocumentClass->update();
            return response()->json([
                "message" => "DocumentClass record updated"
            ],201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteDocumentClass(DocumentClass $documentClass)
    {
        if($documentClass->slug)
        {
            $documentClass->delete();
            return response()->json([
                "message" => "DocumentClass Deleted"
            ], 200);
        }else 
        {
            return response()->json([
                "message" => "DocumentClass Not Found"
            ],404);
        }
    }
}
