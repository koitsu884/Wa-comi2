<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        Log::debug('wait');
        return [
            'id' => $this->id,
            'email' => $this->when(Auth::user() != null, $this->email),
            'name' => $this->name,
            'introduction' => $this->introduction,
            'avatar' => $this->getMainImage(),
            'twitter' => $this->twitter,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
       //     'admin' => $this->admin ? true : false
        ];
    }
}
