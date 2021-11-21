<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trail\UploadImage;
use App\Http\Resources\CurrencyResource;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Deposit;
use App\Models\Order;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\OrderResource;
use App\Http\Resources\WalletResource;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\WithdrawalResource;

class OrderApiController extends Controller
{
    use UploadImage;
    public function currency(){
        try {
            return response()->json([
                "status" => true,
                "data" => CurrencyResource::collection(Currency::all())
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }
    }

    public function order(Request $request){
        try {
            $clientId = $request->user()->currentAccessToken()->tokenable->id;
            $client = Client::find($clientId);
            $validator=  Validator::make($request->all(), [
                'amount' => 'required|numeric',
                'image' => 'required|file|image|max:50000|mimes:jpeg,png,jpg',
                'crypto_currency' => 'required',
                'crypto_rate' => 'required',
                'currency_id' => 'required|exists:currencies,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "msg" => $validator->errors()->first(),
                ], 422);
            }
            $currency = Currency::find($request->currency_id);

           $order = new Order();
           $order->amount = $request->amount;
           $order->rate = $currency->rates->last()->rate;
           $order->image = $this->upload($request,'order_images');
           $order->crypto_currency = $request->crypto_currency;
           $order->crypto_rate = $request->crypto_rate;
           $order->currency_id = $request->currency_id;
           $order->client_id =$clientId;
           $order->save();

            return response()->json(['status' => true ,'msg' => 'success']);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }
    }

    public function withdrawal(Request $request){
        try {
            $clientId = $request->user()->currentAccessToken()->tokenable->id;
//            $client = Client::find($clientId);
            $validator=  Validator::make($request->all(), [
                'crypto_amount' => 'required|numeric',
                'crypto_rate' => 'required',
                'crypto_currency' => 'required',
                'currency_id' => 'exists:currencies,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "msg" => $validator->errors()->first(),
                ], 422);
            }
            $currency = Currency::find($request->currency_id);
            $amount = ($request->crypto_amount * $request->crypto_rate) * $currency->rates->last()->rate_sell;


            $withdrawal = new Withdrawal();
            $withdrawal->crypto_amount = $request->crypto_amount;
            $withdrawal->crypto_rate = $request->crypto_rate;
            $withdrawal->crypto_currency =$request->crypto_currency;
            $withdrawal->amount = $amount;
            $withdrawal->rate_sell = $currency->rates->last()->rate_sell;
            $withdrawal->client_id = $clientId;
            $withdrawal->currency_id = $request->currency_id;
            $withdrawal->save();



            return response()->json(['status' => true ,'msg' => 'success']);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }
    }

    public function yourOrder(Request $request){
        try {
            $clientId = $request->user()->currentAccessToken()->tokenable->id;
            return response()->json([
                "status" => true,
                "data" => OrderResource::collection(Order::where('client_id',$clientId)->latest()->get())
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }
    }
    public function yourWithdrawal(Request $request){
        try {
            $clientId = $request->user()->currentAccessToken()->tokenable->id;
            return response()->json([
                "status" => true,
                "data" => WithdrawalResource::collection(Withdrawal::where('client_id',$clientId)->latest()->get())
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }
    }

    public function wallet(Request $request){
        try {
            $clientId = $request->user()->currentAccessToken()->tokenable->id;
            $deposit = DB::table('deposits')
                ->select('crypto_currency',DB::raw('SUM(crypto_amount) as sum_crypto'))
                ->where('client_id',$clientId)
                ->groupBy('crypto_currency')->get();
            $withdrawal = DB::table('withdrawals')
                ->select('crypto_currency',DB::raw('SUM(crypto_amount) as sum_crypto'))
                ->where('client_id',$clientId)
                ->groupBy('crypto_currency')->get();





            return response()->json([
                "status" => true,
                "data" => $this
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }
    }
}
