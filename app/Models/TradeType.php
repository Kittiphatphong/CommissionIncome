<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeType extends Model
{
    use HasFactory;

    public function trades(){
        return $this->hasMany(Trade::class,'trade_type_id');
    }
}
