<?php

namespace Modules\Settings\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Settings\app\Models\Rank;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllRanks()
    {
       $ranks = Rank::all();
       return response()->json([
        'message' => 'All ranks fetched',
        'ranks' => $ranks
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createRank(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'rank_name' => 'required'
        ]);
        if($validated->fails())
        {
            return response()->json([
                'message' => $validated->messages()
            ], 401);
        }
        else{
            $rank = new Rank;
            $rank->rank_name = $request->rank_name;
            $rank->slug = Str::slug($rank->rank_name);
            $rank->save();
            return response()->json([
                'message' => 'Rank created successfully',
                'rank' => $rank
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateRank(Request $request, Rank $rank)
    {
        if($rank->slug)
        {
            $rank->rank_name= is_null($request->rank_name) ? $rank->rank_name: $request->rank_name; 
            $rank->slug= is_null($request->rank_name) ? $rank->slug: Str::slug($rank->rank_name); 
            //$rank->created_by = is_null($request->updated_by) ? $rank->updated_by : $request->updated_by;
            $rank->update();
            return response()->json([
                "message" => "rank record updated"
            ],201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteRank(Rank $rank)
    {
        if($rank->slug)
        {
            $rank->delete();
            return response()->json([
                "message" => "Rank Deleted"
            ], 200);
        }else 
        {
            return response()->json([
                "message" => "Rank Not Found"
            ],404);
        }
    }
}
