<?php
namespace App\Http\Traits;

use App;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Auth;

trait FileUploads
{
    public function uploadFile(Request $request, $entity)
    {
        $file = $request->file('file');
        $fileName = $request->name.$file->extension();
        $path = 'uploads';
        $file->storeAs($path, $fileName);
        $fileUpload 			   = new FileUpload();
        $fileUpload->uploaded_by   = Auth::user()->id;
        $fileUpload->entity_id     = $entity->id;
        $fileUpload->entity_type   = get_class($entity);
        $fileUpload->file_size     = round($file->getSize()/1000000,2); //convert file size to mb
        $fileUpload->save();
        return response()->json([
            "success" => true,
            "message" => "Image has been uploaded successfully."
        ]);

        //$filePath = public_path(). '/files';
        //$file->move($filePath, $fileName);
        //$fileUpload->facility_id   = $entity->facility_id;
    }

    public function getAllFIles()
    {

    }

    public function downloadFile ($id){
        $attachment = FileUpload::find($id);
        $file = 'uploads/'.$attachment->fileName;
        $fileExists = Storage::exists($file);
        if($fileExists){
            return Storage::download($file, $attachment->fileName);
        }else{
            return response()->json([
                "message" => "File not Found"
            ]);
        }
    }
}
