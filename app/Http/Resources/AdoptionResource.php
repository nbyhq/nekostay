<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdoptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cat_id' => $this->cat_id,
            'cat_name' => $this->whenLoaded('cat', fn () => $this->cat->name),
            'adopter_name' => $this->adopter_name,
            'adopter_phone' => $this->adopter_phone,
            'adopter_address' => $this->adopter_address,
            'status' => $this->status,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
