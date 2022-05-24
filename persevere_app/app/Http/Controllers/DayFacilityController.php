<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Day,Facility,DayFacility};
use App\Http\Resources\{DayResource,FacilityResource,DayFacilityResource};
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DayFacilityController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Day $day, Facility $facility)
    {
        $validator = Validator::make($request->all(), [
            'start_hour' => 'required|integer',
            'start_minute' => 'required|integer',
            'end_hour' => 'required|integer',
            'end_minute' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Create new DayFacility instance
        $inputs = $request->all();

        $day_facility = new DayFacility();
        $day_facility->start_hour = $inputs['start_hour'];
        $day_facility->start_minute = $inputs['start_minute'];
        $day_facility->end_hour = $inputs['end_hour'];
        $day_facility->end_minute = $inputs['end_minute'];
        $day_facility->day_id = $day->id;
        $day_facility->facility_id = $facility->id;
        $day_facility->save();

        return response()->json(["success" => new DayFacilityResource($day_facility)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DayFacility $DayFacility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DayFacility $dayFacility)
    {
        $dayFacility->delete();

        return response()->json(["success" => "Paramétrage supprimé avec succès !"]);
    }
}