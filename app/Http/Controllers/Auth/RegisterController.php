<?php

namespace App\Http\Controllers\Auth;

// use Illuminate\Support\Facades\Auth;
use Modules\UserManagement\app\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Auth;

class RegisterController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function register(Request $request)
    {
        //save and return json
        $validated = Validator::make($request->all(),[
            'username' => 'required|unique:users|max:255',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' =>'required|email',
            'phone' =>'required|unique:users|max:11',
            'password' => 'required'
        ]);

        if($validated->fails()){
            return response()->json([
                "status" => 422,
                "message" => $validated->messages()
            ],422);
        }

        else{
            $user = new User;
            $user->username = $request->username;
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            $accessToken = $user->createToken('authToken')->accessToken;
            return response()->json([
                "message" => "User saved",
                "user" => $user,
                "token" => $accessToken,
            ],201);
        }
        // $this->login($user);
        // return $this->registered($request, $user);
    }

    // protected function registered(Request $request, $user)
    // {
    //     $user->generateToken();
    //     return response()->json(['data' => $user->toArray()], 201);
    // }
}
