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

    public function kyc_clients(){
        return $this->hasMany(KycClient::class,'client_id');
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

    public function clientProgress(){
        $email_score=1;
        $info_score=0;
        $profile_score=0;
        $otp_score=0;
        $verify_score = 0;
         if($this->firstname != null){
             $info_score=1;
         }
        if($this->image != null){
            $profile_score=1;
        }if ($this->otps->status == 1 || $this->otps->status == 3){
            $otp_score=3;
        }if ($this->status_id == 4){
            $verify_score = 4;
        }
        $score = $email_score+$profile_score+$otp_score+$info_score+$verify_score;
        $percent = ($score*100)/10;
        return $percent;

    }


}
