<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    public function clients(){
        return $this->belongsTo(Client::class,'client_id');
    }

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function currencies(){
        return $this->belongsTo(Currency::class,'currency_id');
    }
}
