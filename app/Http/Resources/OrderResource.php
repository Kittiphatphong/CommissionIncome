<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->status === 1){
            $status = "SUCCESS";
        }
        if ($this->status === 0){
            $status = "FAIL";
        }  if ($this->status === null){
        $status = "PENDING";
    }

        return [
            'id' => $this->id,
            'amount' => (string) $this->amount,
            'currency' => $this->currencies->name,
            'snip_image' => env('DOMAIN_NAME_P').$this->image,
            'status' => $status,
            'crypto_currency' => $this->crypto_currency,
            'crypto_rate' =>(string) $this->crypto_rate,
            'date_time' => $this->created_at,
            'your_crypto' =>(string) $this->your_crypto()
        ];
    }
}
