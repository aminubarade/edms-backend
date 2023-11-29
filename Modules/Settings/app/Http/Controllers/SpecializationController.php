<?php

namespace Modules\Settings\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Settings\app\Models\Specialization;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SpecializationController extends Controller
{
    public function getAllSpecializations()
    {
       $specializations = Specialization::all();
       return response()->json([
        'message' => 'All specializations fetched',
        'specializations' => $specializations
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createSpecialization(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'specialization_name' => 'required'
        ]);
        if($validated->fails())
        {
            return response()->json([
                'message' => $validated->messages()
            ], 401);
        }
        else{
            $specialization = new Specialization;
            $specialization->specialization_name = $request->specialization_name;
            $specialization->slug = Str::slug($specialization->specialization_name);
            $specialization->save();
            return response()->json([
                'message' => 'specialization created successfully',
                'specialization' => $specialization
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatespecialization(Request $request, Specialization $specialization)
    {
        if($specialization->slug)
        {
            $specialization->specialization_name= is_null($request->specialization_name) ? $specialization->specialization_name: $request->specialization_name; 
            $specialization->slug= is_null($request->specialization_name) ? $specialization->slug: Str::slug($specialization->specialization_name); 
            //$specialization->created_by = is_null($request->updated_by) ? $specialization->updated_by : $request->updated_by;
            $specialization->update();
            return response()->json([
                "message" => "specialization record updated"
            ],201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deletespecialization(specialization $specialization)
    {
        if($specialization->slug)
        {
            $specialization->delete();
            return response()->json([
                "message" => "specialization Deleted"
            ], 200);
        }else 
        {
            return response()->json([
                "message" => "specialization Not Found"
            ],404);
        }
    }
}
