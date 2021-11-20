<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\KycClient;
use App\Models\KycType;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Resources\CountryResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Trail\UploadImage;
class KycApiController extends Controller
{
    use UploadImage;
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

    public function kycClient(Request $request){
        try {
            $clientId = $request->user()->currentAccessToken()->tokenable->id;
            $client = Client::find($clientId);
            $validator=  Validator::make($request->all(), [
                'number' => 'required',
                'image' => 'required|file|image|max:50000|mimes:jpeg,png,jpg',
                'selfie_image' => 'required|file|image|max:50000|mimes:jpeg,png,jpg',
                'type_id' => 'required|exists:kyc_types,id',
                'country_id' => 'required|exists:countries,id'

            ]);
            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "msg" => $validator->errors()->first(),
                ], 422);
            }


            if ($client->kyc_clients->whereNull('status')->count() > 0 ){
                return response()->json([
                    "status" => false,
                    "msg" => 'This User Is Pending Verify',
                ], 422);
            }

            if ( $client->kyc_clients->where('status',1)->count() > 0){
                return response()->json([
                    "status" => false,
                    "msg" => 'This User Is Verified',
                ], 422);
            }

            $client->status_id = 2;
            $client->save();
            $kyc_client= new KycClient();
            $kyc_client->number = $request->number;
            $kyc_client->type_id = $request->type_id;
            $kyc_client->country_id = $request->country_id;
            $kyc_client->client_id = $clientId;
            $kyc_client->no = $client->kyc_clients->count() + 1;
            $kyc_client->image = $this->uploadFile($request->image,'passport_images');
            $kyc_client->selfie_image = $this->uploadFile($request->selfie_image,'selfie_images');
            $kyc_client->save();
            return response()->json(['status' => true ,'msg' => 'success']);

        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }
    }
}
