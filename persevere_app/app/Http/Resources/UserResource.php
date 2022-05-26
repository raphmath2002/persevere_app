<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Advertisement;


class UserResource extends JsonResource
{
    private function haveNotif() {
        $adverts = Advertisement::all()->pluck('id');
        $user_reads = $this->advertisement_user->pluck('pivot.advertisement_id')->all();

        foreach ($adverts as $id) {
            if(!in_array($id, $user_reads)) return true;
        }

        return false;

    }

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
            'password' => $this->password,
            'phone' => $this->phone,
            'postal_code' => $this->postal_code,
            'postal_address' => $this->postal_address,
            'city' => $this->city,
            'country' => $this->country,
            'storage_path' => $this->storage_path,
            'api_token' => $this->api_token,
            'auth_level' => $this->auth_level,
            'have_notif' => $this->haveNotif(),
            'horses' => HorseResource::collection($this->horses),
            'tickets' => TicketResource::collection($this->tickets),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}