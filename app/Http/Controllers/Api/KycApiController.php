<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\KycType;
use Illuminate\Http\Request;
use App\Http\Resources\CountryResource;

class KycApiController extends Controller
{
    public function kycType(){
        try {
            return response()->json([
                "status" => true,
                "data" => KycType::select('id','name')->get()
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }
    }

    public function countries(){
        try {
            return response()->json([
                "status" => true,
                "data" => CountryResource::collection(Country::OrderBy('code2l')->where('enabled',1)->get())
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }
    }
}
