<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    public function currencies(){
        return $this->belongsTo(Currency::class,'currency_id');
    }

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
}
