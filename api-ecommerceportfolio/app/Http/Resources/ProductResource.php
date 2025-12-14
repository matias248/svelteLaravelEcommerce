<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price, 
            'imageUrl' => $this->image_url ?? "",
            'inventoryStatus' => $this->inventory_status,
            'category' => $this->category,
            'storeId' => $this->store_id,
            'currency' => $this->currency,
        ];
    }
}
