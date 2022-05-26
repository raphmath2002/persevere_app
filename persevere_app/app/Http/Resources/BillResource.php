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
            'due_date' => $this->start_date,
            'global_pricing' => $this->global_pricing,
            'details_pricing' => $this->details_pricing,
            'horses_pensions' => $this->horses_pensions,
            'horses_options' => $this->horses_options,
            'user' => $this->user,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}