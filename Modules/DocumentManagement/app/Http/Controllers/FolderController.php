<?php

namespace Modules\DocumentManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\DocumentManagement\app\Models\Folder;
use Modules\DepartmentManagement\app\ModelsDepartment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function createFolder(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'folder_title' => 'required|unique:folders|max:255',
            'class' => 'required',
        ]);

        if($validated->fails())
        {
            return response()->json([
                "status" => 422,
                "message" => $validated->messages()
        ],422);
        }
        else{
            $folder = new Folder;
            $folder->folder_title = $request->folder_title;
            $folder->slug = Str::slug($folder->folder_title);
            $folder->class = $request->class;
            $folder->department_id = $request->department_id;
            $folder->user_id = $request->user_id; 
            $folder->folder_reference = $request->folder_reference;
            //folder
            $folder->save();
            return response()->json([
                "message" => "folder created successfully.",
                'Created folder' => $folder
            ],201);
        }
    }

    public function getDeptFolders(Department $department)
    {
        return response()->json([
            'message' => '',
            'folders' => $department->folders
        ]);
    }

    public function viewFolder(Folder $folder)
    {
        return response()->json([

            'message' => '',
            'Documents' => $folder->documents
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateFolder(Request $request, Folder $folder)
    {
        if($folder->slug)
        {
            $folder->folder_title= is_null($request->folder_title) ? $folder->folder_title: $request->folder_title; 
            $folder->slug= is_null($request->folder_title) ? $folder->slug: Str::slug($folder->folder_title); 
            $folder->update();
            return response()->json([
                "message" => "folder record updated"
            ],201);
        }
    }

 
    public function destroy($id)
    {
        //
    }
}
