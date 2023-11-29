<?php

namespace Modules\Settings\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Settings\app\Models\Religion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ReligionController extends Controller
{
    public function getAllReligions()
    {
       $religions = religion::all();
       return response()->json([
        'message' => 'All religions fetched',
        'religions' => $religions
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createReligion(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'religion_name' => 'required'
        ]);
        if($validated->fails())
        {
            return response()->json([
                'message' => $validated->messages()
            ], 401);
        }
        else{
            $religion = new Religion;
            $religion->religion_name = $request->religion_name;
            $religion->slug = Str::slug($religion->religion_name);
            $religion->save();
            return response()->json([
                'message' => 'religion created successfully',
                'religion' => $religion
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateReligion(Request $request, Religion $religion)
    {
        if($religion->slug)
        {
            $religion->religion_name= is_null($request->religion_name) ? $religion->religion_name: $request->religion_name; 
            $religion->slug= is_null($request->religion_name) ? $religion->slug: Str::slug($religion->religion_name); 
            //$religion->created_by = is_null($request->updated_by) ? $religion->updated_by : $request->updated_by;
            $religion->update();
            return response()->json([
                "message" => "religion record updated"
            ],201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deletereligion(Religion $religion)
    {
        if($religion->slug)
        {
            $religion->delete();
            return response()->json([
                "message" => "religion Deleted"
            ], 200);
        }else 
        {
            return response()->json([
                "message" => "religion Not Found"
            ],404);
        }
    }
}
