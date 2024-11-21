<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleNeedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'organization_id' => $this->organization_id,
            'category_id' => $this->category_id,
            'item_name' => $this->item_name,
            'language_id' => $this->language_id,
            'quantity_needed' => $this->quantity_needed,
            'donated_quantity' => $this->donated_quantity,
            'description' => $this->description,
            'urgency' => $this->urgency,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
