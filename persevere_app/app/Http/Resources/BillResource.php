<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
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
            'reference' => $this->reference,
            'start_date' => $this->start_date,
            'pricing' => $this->pricing,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}