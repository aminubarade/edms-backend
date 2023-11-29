<?php

namespace Modules\Settings\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Settings\app\Models\Branch;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class BranchController extends Controller
{
    public function getAllBranches()
    {
       $branches = branch::all();
       return response()->json([
        'message' => 'All Branches fetched',
        'Branches' => $branches
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createBranch(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'branch_name' => 'required'
        ]);
        if($validated->fails())
        {
            return response()->json([
                'message' => $validated->messages()
            ], 401);
        }
        else{
            $branch = new Branch;
            $branch->branch_name = $request->branch_name;
            $branch->slug = Str::slug($branch->branch_name);
            $branch->save();
            return response()->json([
                'message' => 'branch created successfully',
                'branch' => $branch
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateBranch(Request $request, Branch $branch)
    {
        if($branch->slug)
        {
            $branch->branch_name= is_null($request->branch_name) ? $branch->branch_name: $request->branch_name; 
            $branch->slug= is_null($request->branch_name) ? $branch->slug: Str::slug($branch->branch_name); 
            //$branch->created_by = is_null($request->updated_by) ? $branch->updated_by : $request->updated_by;
            $branch->update();
            return response()->json([
                "message" => "Branch record updated"
            ],201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteBranch(Branch $branch)
    {
        if($branch->slug)
        {
            $branch->delete();
            return response()->json([
                "message" => "branch Deleted"
            ], 200);
        }else 
        {
            return response()->json([
                "message" => "branch Not Found"
            ],404);
        }
    }
}
