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
            'subscribe_date' => $this->subscribe_date,
            'unsubscribe_date' => $this->unsubscribe_date,
            'horse' => $this->horse,
            'option' => $this->option,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}