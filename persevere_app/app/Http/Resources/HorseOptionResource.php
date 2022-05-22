<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HorseOptionResource extends JsonResource
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
            'horse' => $this->horse,
            'option' => $this->option,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}