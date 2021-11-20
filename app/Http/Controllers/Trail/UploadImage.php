<?php

namespace App\Http\Controllers\Trail;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
trait UploadImage
{

    public function gen_code($id,$code){

        $count = strlen($id);
        $codeId= null;
        switch ($count){
            case 1:
                $codeId ='000-'.'00'.$id;
                break;
            case 2:
                $codeId ='000-'.'0'.$id;
                break;
            case 3:
                $codeId ='000-'.$id;
                break;
            case 4:
                $codeId ='00'.substr($id,0,1).'-'.substr($id,1);
                break;
            case 5:
                $codeId ='0'.substr($id,0,2).'-'.substr($id,2);
                break;
            case 6:
                $codeId =substr($id,0,3).'-'.substr($id,3);
                break;
            default:
                $codeId =$id;
                break;
        }

        return $code.'-'.$codeId;

    }


    public function uploadImage($file,$id,$model,$folderName,$name_id){
        $string = rand(0,1000);
        $stringImageReformat = base64_encode('_'.time());
        $ext = $file->getClientOriginalName();
        $imageName =  $string.$stringImageReformat.".".$ext;
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
        $string = rand(0,1000);
        $stringImageReformat = base64_encode('_'.time());
        $ext = $file->getClientOriginalExtension();
        $imageName = $string.$stringImageReformat.".".$ext;
        $imageEncode = File::get($file);
        Storage::disk('local')->put('public/'.$folder.'/'.$imageName, $imageEncode);
        return "/storage/".$folder."/".$imageName;
    }

    public function deleteImageJ($name,$folder){
        Storage::delete("public/".$folder."/".str_replace('/storage/'.$folder.'/','',$name));
    }

    public function editImage($request,$name,$folder){
        $this->deleteImageJ($name,$folder);
        return  $this->upload($request,$folder);
    }


}
