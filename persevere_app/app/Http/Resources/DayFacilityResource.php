<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DayFacilityResource extends JsonResource
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
            'start_hour' => $this->start_hour,
            'start_minute' => $this->start_minute,
            'end_hour' => $this->end_hour,
            'end_minute' => $this->end_minute,
            'day' => $this->day,
            'facility' => $this->facility,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}