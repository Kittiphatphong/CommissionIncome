<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class Client extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public function client_statuses(){
        return $this->belongsTo(ClientStatus::class,'status_id');
    }

    public function otps(){
        return $this->hasOne(OTP::class);
    }

    public function requestNewOTP(){
        $otp = new OTP();
        $otp->client_id = $this->id;
        $otp->otp_number = rand(1000,9999);
        $otp->save();
    }
    public function requestNewOTPAgain(){
        $otps = OTP::where('client_id',$this->id)->pluck('id');
        $otp = OTP::find($otps->first());
        $otp->otp_number = rand(1000,9999);
        $otp->limit_request=$otp->limit_request+1;

        $otp->save();
    }


}
