<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'contact_info' => $this->contact_info,
            'details' => $this->details->map(function ($detail) {
                return [
                    'name' => $detail->name,
                    'location' => $detail->location,
                    'description' => $detail->description,
                    'language_id' => $detail->language_id,
                ];
            }),
        ];
    }
}
