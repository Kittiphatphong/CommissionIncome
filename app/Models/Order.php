<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function currencies(){
        return $this->belongsTo(Currency::class,'currency_id');
    }

    public function clients(){
        return $this->belongsTo(Client::class,'client_id');
    }

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function your_crypto_usdt(){
        $your_crypto = ($this->amount / $this->rate);
        return $your_crypto;
    }
    public function your_crypto(){
        $your_crypto = ($this->amount / $this->rate) / $this->crypto_rate;
        return $your_crypto;
    }
}
