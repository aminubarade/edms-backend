<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Modules\UserManagement\app\Models\User;
use Auth;

class LoginController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function login(Request $request)
    {
        if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $user_token['token'] =  $user->createToken('token')->accessToken; 
            return response()->json([
                'success' => true,
                'token' => $user_token,
                'message'=> "successfully logged in",
                'user' => $user
            
                
            ], 200); 
        } 
        else{ 
            return response()->json([
                'error'=>'Unauthorised'
            ], 401); 
        } 
    }

    public function logout(Request $request)
    {
        if (Auth::user()) {
            $request->user()->token()->revoke();
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully',
            ], 200);
        }

        // $user = Auth::guard('api')->user();
        // if ($user) {
        // $user->api_token = null;
        // $user->save();
        // }
        // return response()->json(['data' => 'User logged out.'], 200);
    }
}
