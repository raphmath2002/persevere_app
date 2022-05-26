<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Facility};
use App\Http\Resources\FacilityResource;
use Illuminate\Support\Facades\Validator;

class FacilityController extends Controller
{
    /**
     * Show facilities.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $facilities = Facility::all();

        return response()->json(["success" => FacilityResource::collection($facilities)]);
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
            'description' => 'required|string|max:2048',
            'max_customers' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Create new Facility instance
        $inputs = $request->all();

        $facility = new Facility();
        $facility->name = $inputs['name'];
        $facility->description = $inputs['description'];
        $facility->max_customers = $inputs['max_customers'];
        $facility->save();

        return response()->json(["success" => new FacilityResource($facility)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facility $facility
     * @return \Illuminate\Http\Response
     */
    public function edit(Facility $facility)
    {
        return response()->json(["success" => new FacilityResource($facility)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facility $facility
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facility $facility)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2048',
            'max_customers' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Update Facility
        $inputs = $request->all();

        $facility->name = $inputs['name'];
        $facility->description = $inputs['description'];
        $facility->max_customers = $inputs['max_customers'];
        $facility->update();

        return response()->json(["success" => new FacilityResource($facility)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facility $facility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facility $facility)
    {
        $facility->delete();

        return response()->json(["success" => "Equipement supprimé avec succès !"]);
    }
}
