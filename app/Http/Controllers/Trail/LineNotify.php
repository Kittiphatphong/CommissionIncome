<?php

namespace App\Http\Controllers\Trail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

trait LineNotify
{


    public function client_order ($message){
        $sToken = "gA09FaSjFYMTwJVlHmtzTbTHpbtOZIEY4iiXcRMnc98";
        $this->sendLineMsg($sToken,$message);
    }
    public function client_withdrawal ($message){
        $sToken = "pvDJ8Jzzqk09z0YU8gnKAXsZ14821poKnonsSrwcmXk";
        $this->sendLineMsg($sToken,$message);
    }


    public function sendLineMsg($stoken,$message) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Bangkok");

        $sToken = $stoken;
        $sMessage = $message;

        $chOne = curl_init();
        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt( $chOne, CURLOPT_POST, 1);
        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage);
        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec( $chOne );

        //Result error
        if(curl_error($chOne))
        {
            echo 'error:' . curl_error($chOne);
        }
        else {
            $result_ = json_decode($result, true);

        }

        curl_close( $chOne );


    }
}
