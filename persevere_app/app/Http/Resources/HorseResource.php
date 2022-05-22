<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HorseResource extends JsonResource
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
            'size' => $this->size,
            'weigth' => $this->weigth,
            'birth_date' => $this->birth_date,
            'birth_country' => $this->birth_country,
            'sire_code' => $this->sire_code,
            'ueln_code' => $this->ueln_code,
            'sex' => $this->sex,
            'storage_path' => $this->storage_path,
            'pension' => $this->pension,
            'user' => $this->user,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}