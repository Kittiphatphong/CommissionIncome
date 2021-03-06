<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycClient extends Model
{
    use HasFactory;

    public function clients(){
        return $this->belongsTo(Client::class,'client_id');
    }

    public function countries(){
        return $this->belongsTo(Country::class,'country_id');
    }

    public function kyc_types(){
        return $this->belongsTo(KycType::class,'type_id');
    }

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
}
