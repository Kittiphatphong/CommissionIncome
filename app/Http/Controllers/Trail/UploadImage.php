<?php

namespace App\Http\Controllers\Trail;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
trait UploadImage
{
    public function uploadImage($file,$id,$model,$folderName,$name_id){
            $stringImageReformat = base64_encode('_'.time());
            $ext = $file->getClientOriginalName();
            $imageName = $stringImageReformat.".".$ext;
            $imageEncode = File::get($file);
            $model->$name_id= $id;
            $model->image = "/storage/".$folderName."/".$imageName;
            $model->save();
            Storage::disk('local')->put('public/'.$folderName.'/'.$imageName, $imageEncode);
    }

    public function deleteImage($model,$folderName,$name_id,$database){
        foreach ($model->$name_id as $images){
            Storage::delete("public/".$folderName."/".str_replace('/storage/'.$folderName.'/','',$images->image));
        }
        DB::table($database)->whereIn('id',$model->$name_id->pluck('id')->toArray())->delete();
    }

    public function editImages(){

    }


    public function upload($request,$folder){
        $stringImageReformat = base64_encode('_'.time());
        $ext = $request->file('image')->getClientOriginalExtension();
        $imageName = $stringImageReformat.".".$ext;
        $imageEncode = File::get($request->image);
        Storage::disk('local')->put('public/'.$folder.'/'.$imageName, $imageEncode);
        return "/storage/".$folder."/".$imageName;
    }

    public function uploadFile($file,$folder){
        $stringImageReformat = base64_encode('_'.time());
        $ext = $file->getClientOriginalExtension();
        $imageName = $stringImageReformat.".".$ext;
        $imageEncode = File::get($file);
        Storage::disk('local')->put('public/'.$folder.'/'.$imageName, $imageEncode);
        return "/storage/".$folder."/".$imageName;
    }

    public function delete($model,$folder){
        Storage::delete("public/".$folder."/".str_replace('/storage/'.$folder.'/','',$model->image));
    }

    public function editImage($request,$model,$folder){
        $this->delete($model,$folder);
        return  $this->upload($request,$folder);
    }


}
