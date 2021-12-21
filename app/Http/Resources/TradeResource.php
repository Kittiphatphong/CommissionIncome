<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TradeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->date_time_expire <= Carbon::now()){
            $status = 1;
        }else{
            $status = 0;
        }
        return [
            'trade_type' => $this->trade_types->timeout,
            'trade_amount' => (string)$this->trade_amount,
            'crypto_currency' => $this->crypto_currency,
            'trade_crypto_currency' => $this->trade_crypto_currency,
            'trade_result' => (string) $this->trade_result,
            'type' => $this->type,
            'crypto_rate' => (string) $this->crypto_rate,
            'time_start_trade' => Carbon::parse($this->created_at)->toDateTimeString(),
            'time_end_trade' => Carbon::parse($this->date_time_expire)->toDateTimeString(),
            'status' => $status
        ];
    }
}
