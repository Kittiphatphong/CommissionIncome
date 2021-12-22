<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Currency;
use App\Models\LineId;
use App\Models\Order;
use App\Models\Trade;
use App\Models\TradeType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TradeResource;
use App\Http\Controllers\Trail\LineNotify;
class TradeApiController extends Controller
{
    use LineNotify;
    public function typeTrade(Request $request){
        try {

            return response()->json([
                "status" => true,
                "data" => TradeType::orderBy('timeout')->select('id','timeout','percent','min','max')->get()
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }
    }

    public function tradeList(Request $request){
        try {
            $clientId = $request->user()->currentAccessToken()->tokenable->id;
            $client = Client::find($clientId);
            $data = Trade::where('client_id',$clientId)->latest()->get();
            return response()->json([
                "status" => true,
                "data" => TradeResource::collection($data)
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }
    }

    public function trade(Request $request){
        try {
            $clientId = $request->user()->currentAccessToken()->tokenable->id;
            $client = Client::find($clientId);

            $validator=  Validator::make($request->all(), [
                'trade_type_id' => 'required|exists:trade_types,id',
                'trade_amount' => 'required|numeric',
                'trade_crypto_currency' => 'required',
                'type' => 'required',
                 'crypto_rate' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "msg" => $validator->errors()->first(),
                ], 422);
            }
            $trade_type = TradeType::find($request->trade_type_id);
            if ($request->trade_amount < $trade_type->min){
                return response()->json([
                    "status" => false,
                    "msg" => 'Amount minimum is '.number_format($trade_type->min). ' USDT',
                ], 422);
            }
            if ($request->trade_amount > $trade_type->max){
                return response()->json([
                    "status" => false,
                    "msg" => 'Amount maximum is '.number_format($trade_type->max). ' USDT',
                ], 422);
            }

            if($client->checkWallet('USDT')<$request->trade_amount){
                return response()->json([
                    "status" => false,
                    "msg" => 'Amount Request more than your balance',
                ], 422);
            }
            $trade_type = TradeType::find($request->trade_type_id);
            $trade = new Trade();
            $trade->client_id = $clientId;
            $trade->trade_type_id = $trade_type->id;
            $trade->trade_amount = $request->trade_amount;
            $trade->crypto_currency = 'USDT';
            $trade->trade_crypto_currency = str_replace('USDT','',$request->trade_crypto_currency);
            $trade->trade_result = round('-'.$request->trade_amount);
            $trade->type = $request->type;
            $trade->crypto_rate = $request->crypto_rate;
            $trade->date_time_expire = Carbon::now()->addSeconds($trade_type->timeout);
            $trade->save();

            return response()->json(['status' => true ,'data' => 'success']);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }
    }

    public function usdtTrade(Request $request){
        try {
            $clientId = $request->user()->currentAccessToken()->tokenable->id;
            $client = Client::find($clientId);
            $data = $client->usdt();
            return response()->json([
                "status" => true,
                "usdt" => $data
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ],422);
        }
    }

    public function lineId(){
        $line_id = null;
        if (LineId::all()->count()>0){
            $line_id = LineId::all()->last()->name ;
        }
            return response()->json([
                "status" => true,
                "data" => $line_id
            ]);

    }
}
