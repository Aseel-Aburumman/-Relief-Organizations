<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DonationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'donation_amount' => $this->quantity,
            'need_id' => $this->need_id,
            'donated_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }

}
