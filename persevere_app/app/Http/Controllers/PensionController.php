<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Pension};
use App\Http\Resources\{PensionResource};
use Illuminate\Support\Facades\Validator;

class PensionController extends Controller
{
    /**
     * Show pensions.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pensions = Pension::all();

        return response()->json(["success" => PensionResource::collection($pensions)]);
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
            'price' => 'required|numeric',
            'description' => 'required|string|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Create new Pension instance
        $inputs = $request->all();

        $pension = new Pension();
        $pension->name = $inputs['name'];
        $pension->price = $inputs['price'];
        $pension->description = $inputs['description'];
        $pension->save();

        return response()->json(["success" => new PensionResource($pension)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pension $pension
     * @return \Illuminate\Http\Response
     */
    public function edit(Pension $pension)
    {
        return response()->json(["success" => new PensionResource($pension)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pension $pension
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pension $pension)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Update Pension
        $inputs = $request->all();
        
        $pension->name = $inputs['name'];
        $pension->price = $inputs['price'];
        $pension->description = $inputs['description'];
        $pension->update();

        return response()->json(["success" => new PensionResource($pension)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pension $pension
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pension $pension)
    {
        $pension->delete();

        return response()->json(["success" => "Pension supprimée avec succès !"]);
    }
}
