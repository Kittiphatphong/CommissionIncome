<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

   public function trade_types(){
       return $this->belongsTo(TradeType::class,'trade_type_id');
   }
   public function clients(){
       return $this->belongsTo(Client::class,'client_id');
   }

   public function users(){
       return $this->belongsTo(User::class,'user_id');
   }

}
