<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\Format1Mail;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\OTP;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Resources\ClientResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTPMail;
class ClientApiController extends Controller
{

    protected $limitRequest = 5;
    protected $limitInput = 5;
    protected $dayLimit =1;
    protected $miniteLimit = 3;

    public function registerEmail(Request $request){


        try {
            $validator=  Validator::make($request->all(), [
                'email' => 'required|unique:clients',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "msg" => $validator->errors()->first(),
                ], 422);
            }

            $client = new Client();
            $client->email =$request->email;
            $client->status_id = 1;

            $client->save();

            $client->requestNewOTP();


//            $contentSms= "Your OTP is ". $client->otps->otp_number;
//            $this->sendSMS($client->phone,$contentSms);
            Mail::to($client->email)->send(new SendOTPMail($client->otps->otp_number));

            return response()->json(['status' => true,'msg' => 'successful'],201);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],500);
        }
    }

    public function verifyOTP(Request $request){
        try {
            $validator=  Validator::make($request->all(), [
                'otp_verify' => 'required|numeric',
                'email' => 'exists:clients,email',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "msg" => $validator->errors()->first(),
                ], 422);
            }

            $client = Client::where('email',$request->email)->first();
            $otp = OTP::where('client_id','=',$client->id)->first();
            $start = $client->otps->updated_at->addMinutes($this->miniteLimit);
            $DateLimit = $client->otps->updated_at->addDay($this->dayLimit);

            //Check OTP number
            if($DateLimit->lt(Carbon::now('Asia/Vientiane'))) {
                $otp->limit_input = 0;
                $otp->save();
            }
            if($otp->limit_input>=$this->limitInput){
                    return response()->json(['status' => false ,'msg' => 'You entered the invalid OTP many times please try again next day or contact us'],422);
            }

            if($request->otp_verify == $client->otps->otp_number){
                    if ($otp->status == 1 || $otp->status == 2) {
                        return response()->json(['status' => false, 'msg' => 'This email is verified'], 422);
                    }

                if($start->lt(Carbon::now('Asia/Vientiane'))){
                    return response()->json(['status' => false ,'msg' => 'OTP is expired'],422);
                }

                $otp->status = 2;
                $otp->save();

                return response()->json(['status' => true,'msg' => 'Verify OTP successful']);

            }else{
                $otp->limit_input=$otp->limit_input+1;
                $otp->save();
                return response()->json(['status' => false ,'msg' => 'OTP is incorrect left '.($this->limitInput-$otp->limit_input).' time'],422);
            }
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }

    }
    public function setPassword(Request $request){
        try {

                $validator= Validator::make($request->all(),[
                    'email' => 'exists:clients,email',
                    'password' => 'required|min:8|same:password_confirm',
                    'device_token' => 'required',
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'gender' => 'required',
                    'birthday' => 'required|date',
                ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "msg" => $validator->errors()->first(),
                ], 422);
            }

            $client = Client::where('email',$request->email)->first();
            $otp = OTP::where('client_id','=',$client->id)->first();
            if($client->otps->status == 0){
                return response()->json(['status' => false ,'msg' => 'This email is not verify'],422);
            }
            if($client->otps->status == 1){
                return response()->json(['status' => false ,'msg' => 'This email is success'],422);
            }
            $client->tokens()->delete();
            $client->password = Hash::make($request->password);
                $client->device_token = $request->device_token;
                $client->firstname = $request->firstname;
                $client->lastname = $request->lastname;
                $client->gender = $request->gender;
                $client->birthday = $request->birthday;

            $client->save();
//             $this->clientRegister($request->device_token,$request->phone,$request->firstname." ".$request->lastname,$request->gender,$request->birthday);
            $otp->status = 1;
            $otp->save();

            $token = $client->createToken($request->device_token)->plainTextToken;
            return response()->json(['status' => true ,'data' => ['client'=>Client::find($client->id),'token'=>$token]]);

        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }

    }

    public function setForgotPassword(Request $request){
        try {

            $validator= Validator::make($request->all(),[
                'email' => 'exists:clients,email',
                'password' => 'required|min:8|same:password_confirm',
                'device_token' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "msg" => $validator->errors()->first(),
                ], 422);
            }

            $client = Client::where('email',$request->email)->first();
            $otp = OTP::where('client_id','=',$client->id)->first();
            if($client->otps->status == 0){
                return response()->json(['status' => false ,'msg' => 'This email is not verify'],422);
            }
            if($client->otps->status == 1){
                return response()->json(['status' => false ,'msg' => 'This email is success'],422);
            }
            if($client->otps->status == 3){
                return response()->json(['status' => false ,'msg' => 'This email is not verify '],422);
            }
            $client->tokens()->delete();
            $client->password = Hash::make($request->password);
            $client->device_token = $request->device_token;

            $client->save();
//             $this->clientRegister($request->device_token,$request->phone,$request->firstname." ".$request->lastname,$request->gender,$request->birthday);
            $otp->status = 1;
            $otp->save();


            $content = 'You have new password successful with ip address'. request()->ip().
                ' with Device name '. $request->header('User-Agent');
            Mail::to($client->email)->send(new Format1Mail('Client Forgot Password','Your account have set a new password', $content));

            $token = $client->createToken($request->device_token)->plainTextToken;
            return response()->json(['status' => true ,'data' => ['client'=>Client::find($client->id),'token'=>$token]]);

        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }

    }

    public function requestOTP(Request $request){

        try {
            $validator=  Validator::make($request->all(), [
                'email' => 'required|exists:clients,email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "msg" => $validator->errors()->first(),
                ], 422);
            }

            $client = Client::where('email',$request->email)->first();
            $otp = OTP::where('client_id','=',$client->id)->first();
            $start = $client->otps->updated_at->addMinutes($this->miniteLimit);
            $DateLimit = $client->otps->updated_at->addDay($this->dayLimit);

            if ($request->forgot_password == true){
                $otp->status = 3;
                $otp->save();
            }
            //Check OTP number
            if($DateLimit->lt(Carbon::now('Asia/Vientiane'))) {
                $otp->limit_request = 0;
                $otp->save();
            }
            if($otp->limit_request>=$this->limitRequest){
                    return response()->json(['status' => false ,'msg' => 'You requested OTP many times please try again next day or contact us'],422);
            }
            if($client->otps){

                if($start->gt(Carbon::now('Asia/Vientiane'))){
                    $timeWait = $start->diffInSeconds(Carbon::now('Asia/Vientiane'));
                    return response()->json(['status' => false ,'msg' => 'Waiting about '.gmdate('i:s', $timeWait).' for request new OTP'],422);
                }
            }

            if ($client->otps->count() > 0){

                     if(OTP::where('client_id',$client->id)->first()->id == 1){
                         return response()->json(['status' => false ,'msg' => 'This email is verify'],422);
                     }
//                    if($client->otps->status == 1){
//                        return response()->json(['status' => false ,'msg' => 'This email is verify'],422);
//                    }
                $client->requestNewOTPAgain();
//                $contentSms= "Your OTP is ". Client::find($client->id)->otps->otp_number;
//                $this->sendSMS($client->phone,$contentSms);
                Mail::to($client->email)->send(new SendOTPMail(OTP::where('client_id',$client->id)->first()->otp_number));
                return response()->json(['status' => true, 'mgs' => 'Request new OTP successful left '.($this->limitRequest-($otp->limit_request+1)).' time'],201);

            }
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }
    }

    public function login(Request $request){
        try {
            $validator=  Validator::make($request->all(), [
                'email' => 'required|exists:clients,email',
                'password' => 'required',
                'device_token' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "msg" => $validator->errors()->first(),
                ], 422);
            }
            $client = Client::where('email',$request->email)->first();

            if( $client->otps->status == 0){
                return response()->json(['status' => false ,'msg' => 'This email is not verify'],422);
            }elseif ($client->otps->status == 2 && $client->password == null){
                return response()->json(['status' => false ,'msg' => 'This email is not verify'],422);
            }

            if(! $client || !Hash::check($request->password,$client->password)){

                return response()->json(['status' => false ,'msg' => 'This password is not correct'],422);
            }

            $client->tokens()->delete();
            $client->device_token = $request->device_token;
            $client->save();
            $token =    $client->createToken($request->device_token)->plainTextToken;
            $content = 'You have new login form ip address '. request()->ip().
                       ' with Device name '. $request->header('User-Agent');
             Mail::to($client->email)->send(new Format1Mail('Client Login','Your account have a new login to account', $content));
            return response()->json(['status' => true ,'data' => ['client'=> ClientResource::make(Client::find($client->id)),'token'=>$token]]);

        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],500);
        }
    }

    public function logout(Request $request){
        try {
            $request->user()->currentAccessToken()->delete();
            Client::find($request->user()->currentAccessToken()->tokenable->id);
            return response()->json(['status' => true ,'msg' => 'logout']);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }

    }

    public function profileUpload(Request $request)
    {
        try {
            $clientId = $request->user()->currentAccessToken()->tokenable->id;
            $client = Client::find($clientId);
            if ($request->hasFile("image")) {

                $imageNames = time().'.'.$request->image->extension();
                $stringImageReformat = base64_encode('_' . time());
                $ext = $request->file('image')->getClientOriginalExtension();
                Storage::delete("public/client_image/".str_replace('/storage/client_image/','',$client->image));


                $imageEncode = File::get($request->image);
                $client->image = "storage/client_image/" . $imageNames;
                $client->save();
                Storage::disk('local')->put('public/client_image/' . $imageNames, $imageEncode);

            }

            return response()->json([
                'status' => true,
                'msg' => 'Success',
                'image_link' => env('DOMAIN_NAME').$client->image
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }
    }

    public function clientInformation(Request $request){
        $id = $request->user()->currentAccessToken()->tokenable->id;
        $data = ClientResource::make(Client::find($id));
      return response()->json([
          "status" => true,
          "data" => $data
      ]);
    }
}
