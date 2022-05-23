<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FacilityHorseResource extends JsonResource
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
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'decline_reason' => $this->decline_reason,
            'facility' => $this->facility,
            'horse' => $this->horse,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}