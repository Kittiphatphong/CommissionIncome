<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    public function clients(){
        return $this->belongsTo(Client::class,'client');
    }
    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function orders(){
        return $this->belongsTo(Order::class,'order_id');
    }
}
