<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfessionalResource extends JsonResource
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
            'firstname' => $this->firstname,
            'birth_date' => $this->birth_date,
            'email' => $this->email,
            'profession' => $this->profession,
            'phone' => $this->phone,
            'postal_code' => $this->postal_code,
            'postal_address' => $this->postal_address,
            'city' => $this->city,
            'country' => $this->country,
            'storage_path' => $this->storage_path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}