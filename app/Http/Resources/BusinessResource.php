<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
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
            'address' => $this->address,
            'website' => $this->website,
            'phone' => $this->phone,
            'email' => $this->email,
            'type' => $this->type,
            'business_data' => BusinessDataResource::collection($this->whenLoaded('data')),
            'age_of_business' => $this->age_of_business,
        ];
    }
}
