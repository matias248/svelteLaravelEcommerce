<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'address' => [
                'streetNumber' => $this->street_number,
                'streetName' => $this->street_name,
                'city' => $this->city,
                'state' => $this->state,
                'zipCode' => $this->zip_code,
            ],
            'location' => [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ],
            'contactPhone' => $this->contact_phone,
            'imageUrl' => $this->image_url ?: "",
        ];
    }
}
