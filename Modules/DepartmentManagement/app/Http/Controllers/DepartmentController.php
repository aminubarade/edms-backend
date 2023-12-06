<?php

namespace Modules\DepartmentManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\DepartmentManagement\app\Models\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
   public function createDepartment(Request $request)
   {
    $validated = Validator::make($request->all(),[
        'department_name' => 'required|unique:departments|max:255',
    ]);

    if($validated->fails())
    {
        return response()->json([
            "status" => 422,
            "message" => $validated->messages()
    ],422);
    }
    else{
        $department = new Department;
        $department->department_name = $request->department_name;
        $department->slug = Str::slug($department->department_name);
        $department->facility_id = $request->facility_id;
        $department->parent_id = $request->parent_id;
        $department->save();
        return response()->json([
            "message" => "department created successfully.",
            'Created department' => $department
        ],201);
    }
   }
   public function getAllDepartments()
   {
        $departments = Department::all();
        return response()->json([
            "message" => "all departments",
            "departments" => $departments
        ]);
   }

   public function getDepartmentUsers(Department $department) {
    return response()->json([
        'message' => '',
        'users' => $department->users
    ]);
   }

   public function getDepartmentFolders(Department $department) {
    return response()->json([
        'message' => '',
        'folders' => $department->folders
    ]);
   }

   public function getDepartmentAppointments(Department $department) {
    return response()->json([
        'message' => '',
        'appointments' => $department->appointments
    ]);
   }

   public function getDepartmentDocuments(Department $department) {
    return response()->json([
        'message' => '',
        'documents' => $department->documents
    ]);
   }
   
   public function updateDepartment(Request $request, Department $department)
   {
       if($department->slug)
       {
           $folder->department_name= is_null($request->department_name) ? $department->department_name: $request->department_name; 
           $department->slug= is_null($request->department_name) ? $department->slug: Str::slug($department->department_name); 
           $department->update();
           return response()->json([
               "message" => "Dept record updated"
           ],201);
       }
   }


}
