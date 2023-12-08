<?php

namespace Modules\DocumentManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DocumentManagementController extends Controller
{
    public function uploadFile(Request $request)
    {
        $file = $request->file('file');
        $fileName = 'File'.time().'.'.$file->extension();
        $filePath = public_path(). '/files';

        $file->move($filePath, $fileName);

        return response()->json([
            "success" => true,
            "message" => "Image has been uploaded successfully."
        ]);
    }
}
