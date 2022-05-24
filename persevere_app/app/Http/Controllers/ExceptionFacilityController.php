<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Facility,Exception,ExceptionFacility};
use App\Http\Resources\{FacilityResource,ExceptionResource,ExceptionFacilityResource};
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ExceptionFacilityController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Exception $exception, Facility $facility)
    {
        // Create new ExceptionFacility instance
        $exceptionFacility = new ExceptionFacility();
        $exceptionFacility->exception_id = $exception->id;
        $exceptionFacility->facility_id = $facility->id;
        $exceptionFacility->save();

        return response()->json(["success" => new ExceptionFacilityResource($exceptionFacility)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExceptionFacility $exceptionFacility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ExceptionFacility $exceptionFacility)
    {
        $exceptionFacility->delete();

        return response()->json(["success" => "Exception supprimée avec succès !"]);
    }
}