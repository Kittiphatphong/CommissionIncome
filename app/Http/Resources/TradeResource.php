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
        return [
            'trade_type' => $this->trade_types->timeout,
            'trade_amount' => $this->trade_amount,
            'crypto_currency' => $this->crypto_currency,
            'trade_crypto_currency' => $this->trade_crypto_currency,
            'trade_result' => $this->trade_result,
            'type' => $this->type,
            'time_start_trade' => Carbon::parse($this->created_at)->toDateTimeString(),
            'time_end_trade' => Carbon::parse($this->date_time_expire)->toDateTimeString(),


        ];
    }
}
