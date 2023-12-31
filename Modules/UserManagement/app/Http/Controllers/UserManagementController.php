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
    public function getAllUsers()
    {
        //import users
        $users = User::all();
        return response()->json([
            "message" => "success",
            "users" => $users
        ]);
    }

    public function saveUser(Request $request)
    {
        //save and return json
        $validated = Validator::make($request->all(),[
            'username' => 'required|unique:users|max:255',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' =>'required|email',
            'password' => 'required',
            'phone' =>'required|unique:users|max:11',
            'rank' => 'required',
            'dob' => 'required',
            'service_number' => 'required',
            'appt' => 'required',
            'service' => 'required',
            'unit' => 'required',
            'command' => 'required',
            'department' => 'required'
        ]);

        if($validated->fails()){
            return response()->json([
                "status" => 422,
                "message" => $validated->messages()
            ],422);
        }else
        {
            $user = new User;
            //personal
            $user->username = $request->username;
            $user->firstname = $request->firstname;
            $user->middlename = $request->middlename; //nullable;
            $user->lastname = $request->lastname;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->dob =   date($request->dob,strtotime($request->dob));
            //official info
            $user->rank = $request->rank;
            $user->service_number = $request->service_number;
            $user->appt = $request->appt;//appt table
            $user->service = $request->service;
            $user->department_id = $request->department_id;
            $user->is_active = $request->is_active;
            $user->save();
            return response()->json([
                "message" => "User saved"
            ],201);
        }
    }

    public function viewUser(User $user)
    {
        return $user;
    }

    public function updateUser(Request $request, User $user)
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
            $user->department_id = is_null($request->department_id) ? $user->department_id : $request->department_id; 
            $user->update();
            return response()->json([
                "message" => "User record updated"
            ],201);
        }
    }

    public function deleteUser(User $user)
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

    public function assignTaskToUser(Request $request, User $user)
    {
        return $user->tasks()->attach($request->tasks);
    }
}
