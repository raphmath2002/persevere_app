<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Advertisement,User,AdvertisementUser};
use App\Http\Resources\{AdvertisementResource,UserResource,AdvertisementUserResource};
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AdvertisementUserController extends Controller
{
    /**
     * Show advertisements.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(User $user)
    {
        $adverts = Advertisement::all();

        $user_reads = $user->advertisement_user->pluck('pivot.advertisement_id')->all();

        $non_reads = [];

        foreach ($adverts as $advert) {
            if(!in_array($advert->id, $user_reads)) array_push($non_reads, $advert);
        }

        return response()->json(["success" => AdvertisementResource::collection($non_reads)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Advertisement $advertisement)
    {
        // Create new AdvertisementUser instance
        $advertisementUser = new AdvertisementUser();
        $advertisementUser->user_id = $user->id;
        $advertisementUser->advertisement_id = $advertisement->id;
        $advertisementUser->save();

        return response()->json(["success" => "Notification supprimée !"]);
    }
}
