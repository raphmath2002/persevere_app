<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'duration' => $this->duration,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'max_appointments' => $this->max_appointments,
            'status' => $this->status,
            'cancel_reason' => $this->cancel_reason,
            'professional' => $this->professional,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}