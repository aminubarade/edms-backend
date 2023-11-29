<?php

namespace Modules\Settings\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Settings\app\Models\CommonComment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class CommonCommentController extends Controller
{
    public function getAllCommonComments()
    {
       $commonComments = CommonComment::all();
       return response()->json([
        'message' => 'All commonComments fetched',
        'commonComments' => $commonComments
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createCommonComment(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'commonComment_name' => 'required'
        ]);
        if($validated->fails())
        {
            return response()->json([
                'message' => $validated->messages()
            ], 401);
        }
        else{
            $commonComment = new CommonComment;
            $commonComment->commonComment_name = $request->commonComment_name;
            $commonComment->slug = Str::slug($commonComment->commonComment_name);
            $commonComment->save();
            return response()->json([
                'message' => 'commonComment created successfully',
                'commonComment' => $commonComment
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCommonComment(Request $request, CommonComment $commonComment)
    {
        if($commonComment->slug)
        {
            $commonComment->commonComment_name= is_null($request->commonComment_name) ? $commonComment->commonComment_name: $request->commonComment_name; 
            $commonComment->slug= is_null($request->commonComment_name) ? $commonComment->slug: Str::slug($commonComment->commonComment_name); 
            //$commonComment->created_by = is_null($request->updated_by) ? $commonComment->updated_by : $request->updated_by;
            $commonComment->update();
            return response()->json([
                "message" => "commonComment record updated"
            ],201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteCommonComment(CommonComment $commonComment)
    {
        if($commonComment->slug)
        {
            $commonComment->delete();
            return response()->json([
                "message" => "commonComment Deleted"
            ], 200);
        }else 
        {
            return response()->json([
                "message" => "commonComment Not Found"
            ],404);
        }
    }
}
