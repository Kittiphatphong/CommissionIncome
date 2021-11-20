<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{

    public function toArray($request)
    {



        return [
            'email' => $this->email,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'full_name' => $this->firstname ." ".$this->lastname,
            'birthday' => $this->birthday,
            'gender' => $this->gender,
            'profile_image' => env('DOMAIN_NAME').$this->image,
            'status' => $this->client_statuses->name,
            'status_otp' => $this->otps->status

        ];
    }
}
