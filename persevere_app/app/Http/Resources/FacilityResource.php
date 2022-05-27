<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FacilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'max_customers' => $this->max_customers,
            'facilities_images' => $this->facilities_images,
            'exceptions' => $this->exception_facility,
            'days' => $this->day_facility,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}