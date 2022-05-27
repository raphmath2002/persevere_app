<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Horse, HorseOption};
use App\Http\Resources\{HorseResource};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Image;
use Carbon\Carbon;

class HorseController extends Controller
{
    /**
     * Show horses.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $horses = Horse::all();

        return response()->json(["success" => HorseResource::collection($horses)]);
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
            'name' => 'required|string|max:255',
            'size' => 'required|numeric',
            'weigth' => 'required|numeric',
            'birth_date' => 'required',
            'sire_code' => 'required|string|max:255',
            'ueln_code' => 'required|string|max:255',
            'birth_country' => 'required|string|max:255',
            'sex' => 'required|string|max:255',
            'storage_path' => 'required|string',
            'pension_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Create new Horse instance
        $inputs = $request->all();

        $horse = new Horse();
        $horse->name = $inputs['name'];
        $horse->size = $inputs['size'];
        $horse->weigth = $inputs['weigth'];
        $horse->birth_date = $inputs['birth_date'];
        $horse->sire_code = $inputs['sire_code'];
        $horse->ueln_code = $inputs['ueln_code'];
        $horse->birth_country = $inputs['birth_country'];
        $horse->sex = $inputs['sex'];
        $horse->pension_id = $inputs['pension_id'];
        $horse->user_id = $inputs['user_id'];


        // Photo storage
        $make_image = Image::make($inputs['storage_path']);
        $type = $make_image->mime();
        $extension_path = explode("/", $type)[1];

        $url = 'img_uploads/img_horses/'.trim($horse->name).'.'.$extension_path.'';
        $make_image->save(public_path($url));
        $horse->storage_path = URL::asset($url);

        $horse->save();

        if(isset($inputs['options'])) {
            foreach ($inputs['options'] as $option) {
                $horse_option = new HorseOption();
                $horse_option->horse_id = $horse->id;
                $horse_option->option_id = $option;
                $horse_option->subscribe_date = Carbon::now();
                $horse_option->unsubscribe_date = Carbon::now();
                $horse_option->save();
            }
        }

        return response()->json(["success" => new HorseResource($horse)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Horse $horse
     * @return \Illuminate\Http\Response
     */
    public function edit(Horse $horse)
    {
        return response()->json(["success" => new HorseResource($horse)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Horse $horse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Horse $horse)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'size' => 'required|numeric',
            'weigth' => 'required|numeric',
            'birth_date' => 'required',
            'sire_code' => 'required|string|max:255',
            'ueln_code' => 'required|string|max:255',
            'birth_country' => 'required|string|max:255',
            'sex' => 'required|string|max:255',
            'pension_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Update Horse
        $inputs = $request->all();
        
        $horse->name = $inputs['name'];
        $horse->size = $inputs['size'];
        $horse->weigth = $inputs['weigth'];
        $horse->birth_date = $inputs['birth_date'];
        $horse->sire_code = $inputs['sire_code'];
        $horse->ueln_code = $inputs['ueln_code'];
        $horse->birth_country = $inputs['birth_country'];
        $horse->sex = $inputs['sex'];
        $horse->pension_id = $inputs['pension_id'];
        $horse->user_id = $inputs['user_id'];
        $horse->update();

        return response()->json(["success" => new HorseResource($horse)]);

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Horse $horse
     * @return \Illuminate\Http\Response
     */
    public function update_photo(Request $request, Horse $horse)
    {
        $validator = Validator::make($request->all(), [
            'storage_path' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Update photo
        $inputs = $request->all();

        $make_image = Image::make($inputs['storage_path']);
        $type = $make_image->mime();
        $extension_path = explode("/", $type)[1];

        $url = 'img_uploads/img_horses/'.trim($horse->name).'.'.$extension_path.'';
        $make_image->save(public_path($url));
        $horse->storage_path = URL::asset($url);

        // Delete old photo
        if(file_exists($inputs['storage_path'])){
            unlink($inputs['storage_path']);
        }

        $horse->update();

        return response()->json(["success" => new HorseResource($horse)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Horse $horse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Horse $horse)
    {
        $horse->delete();

        return response()->json(["success" => "Cheval supprimé avec succès !"]);
    }
}
