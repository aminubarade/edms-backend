<?php
namespace App\Traits;

use App;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

trait FileUploads
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
