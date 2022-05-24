<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{FacilitiesImage,Facility};
use App\Http\Resources\{FacilityResource,FacilitiesImageResource};
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Image;

class FacilitiesImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Facility $facility)
    {
        $inputs = $request->all();

        $images = $inputs['images'];

        // Create new FacilitiesImage instance
        foreach($images as $image){
            $facilitiesImage = new FacilitiesImage();
            $facilitiesImage->facility_id = $facility->id;

            $make_image = Image::make($image);
            $type = $make_image->mime();
            $extension_path = explode("/", $type)[1];

            $url = 'img_uploads/img_facilities/'. Str::random(15) .'.'.$extension_path.'';
            $make_image->save(public_path($url));
            $facilitiesImage->storage_path = URL::asset($url);

            $facilitiesImage->save();
        }

        return response()->json(["success" => new FacilityResource($facility)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FacilitiesImage $facilitiesImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacilitiesImage $facilitiesImage)
    {
        // Delete photo
        if(file_exists($facilitiesImage->storage_path)){
            unlink($facilitiesImage->storage_path);
        }

        $facilitiesImage->delete();

        return response()->json('Image supprimée avec succès !');
    }
}
