<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Advertisement};
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
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Create new Advertisement instance
        $inputs = $request->all();

        $advertisement = new Advertisement();
        $advertisement->title = $inputs['title'];
        $advertisement->markdown = $inputs['markdown'];
        $advertisement->user_id = Auth::user()->id;
        $advertisement->save();

        return response()->json(["success" => new AdvertisementResource($advertisement)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Advertisement $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertisement $advertisement)
    {
        return response()->json(["success" => new AdvertisementResource($advertisement)]);
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
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Update Advertisement
        $inputs = $request->all();
        
        $advertisement->title = $inputs['title'];
        $advertisement->markdown = $inputs['markdown'];
        $advertisement->update();

        return response()->json(["success" => new AdvertisementResource($advertisement)]);
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

        return response()->json(["success" => "Annonce supprimée avec succès"]);
    }
}
