<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'details' => $this->userDetails->map(function ($detail) {
                return [
                    'name' => $detail->name,
                    'location' => $detail->location,
                    'language_id' => $detail->language_id,
                ];
            }),
        ];
    }
}
