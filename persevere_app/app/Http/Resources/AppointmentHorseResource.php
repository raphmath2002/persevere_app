<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentHorseResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'cares' => $this->cares,
            'observations' => $this->observations,
            'appointment' => $this->appointment,
            'horse' => $this->horse,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}