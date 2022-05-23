<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Advertisement, User, AdvertisementUser};
use App\Http\Resources\{AdvertisementResource};
use Illuminate\Support\Facades\Validator;
use Auth;

class AdvertisementController extends Controller
{
    /**
     * Show advertisements.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $advertisements = Advertisement::all();

        return response()->json(["success" => AdvertisementResource::collection($advertisements)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'markdown' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(["res" => [
                "code" => 400,
                "error" => $validator->errors()
            ]]);
        }

        // Create new Advertisement instance
        $inputs = $request->all();

        $advertisement = new Advertisement();
        $advertisement->title = $inputs['title'];
        $advertisement->markdown = $inputs['markdown'];
        $advertisement->user_id = Auth::user()->id;
        $advertisement->save();

        return response()->json(["res" => [
            "code" => 200,
            "data" => new AdvertisementResource($advertisement)
        ]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Advertisement $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertisement $advertisement)
    {
        return response()->json(["res" => [
            "code" => 200,
            "data" => new AdvertisementResource($advertisement)
        ]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advertisement $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'markdown' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(["res" => [
                "code" => 400,
                "error" => $validator->errors()
            ]]);
        }

        // Update Advertisement
        $inputs = $request->all();
        
        $advertisement->title = $inputs['title'];
        $advertisement->markdown = $inputs['markdown'];
        $advertisement->update();

        return response()->json(["res" => [
            "code" => 200,
            "data" => new AdvertisementResource($advertisement)
        ]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Advertisement $advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertisement $advertisement)
    {
        $advertisement->delete();

        return response()->json(["res" => [
            "code" => 200,
            "message" => "Annonce supprimée avec succès !"
        ]]);
    }

    public function getAdvertsByUser(User $user) {
        $adverts = Advertisement::all();

        $user_reads = $user->advertisement_user->pluck('pivot.advertisement_id')->all();

        $non_reads = [];

        foreach ($adverts as $advert) {
            if(!in_array($advert->id, $user_reads)) array_push($non_reads, $advert);
        }

        return response()->json(["success" => AdvertisementResource::collection($non_reads)]);
    }

    public function markAdvertAsRead(User $user, Advertisement $advert) {
        $advert_user = new AdvertisementUser();
        $advert_user->user_id = $user->id;
        $advert_user->advertisement_id = $advert->id;
        $advert_user->save();

        return response()->json(["success" => "Notification supprimée !"]);
    }
}
