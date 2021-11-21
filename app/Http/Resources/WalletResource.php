<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class WalletResource extends JsonResource
{

    public function toArray($request)
    {

        return [
        "crypto" => $this->crypto_currency,
        "total" => $this->crypto_amount

        ];
    }
}
