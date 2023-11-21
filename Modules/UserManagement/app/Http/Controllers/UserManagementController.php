<?php

namespace Modules\UserManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\UserManagement\app\Models\User;
use Illuminate\Support\Facades\Validator;
use Hash;



class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //import users
        //
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
        }else{
            $user = new User;
            $user->username = $request->username;
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json([
                "message" => "User saved"
            ],201);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
         //
        if($user->username)
        {
            $user->username = is_null($request->username) ? $user->username : $request->username; 
            $user->firstname = is_null($request->firstname) ? $user->firstname : $request->firstname; 
            $user->lastname = is_null($request->lastname) ? $user->lastname : $request->lastname; 
            $user->phone = is_null($request->phone) ? $user->phone : $request->phone; 
            $user->email = is_null($request->email) ? $user->email : $request->email; 
            $user->password = is_null($request->password) ? $user->password : $request->password; 
            $user->update();
            return response()->json([
                "message" => "User record updated"
            ],201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if($user->username)
        {
            $user->delete();
            return response()->json([
                "message" => "User Deleted"
            ], 200);
        }else {
            return response()->json([
                "message" => "User Not Found"
            ],404);
        }
    }
}
