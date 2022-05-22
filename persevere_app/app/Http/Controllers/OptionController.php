<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Option};
use App\Http\Resources\{OptionResource};
use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
{
    /**
     * Show options.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $options = Option::all();

        return response()->json(["res" => [
            "code" => 200,
            "data" => OptionResource::collection($options)
        ]]);
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
            return response()->json(["res" => [
                "code" => 400,
                "error" => $validator->errors()
            ]]);
        }

        // Create new Option instance
        $inputs = $request->all();

        $option = new Option();
        $option->name = $inputs['name'];
        $option->price = $inputs['price'];
        $option->description = $inputs['description'];
        $option->save();

        return response()->json(["res" => [
            "code" => 200,
            "data" => new OptionResource($option)
        ]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Option $option
     * @return \Illuminate\Http\Response
     */
    public function edit(Option $option)
    {
        return response()->json(["res" => [
            "code" => 200,
            "data" => new OptionResource($option)
        ]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Option $option
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Option $option)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(["res" => [
                "code" => 400,
                "error" => $validator->errors()
            ]]);
        }

        // Update Option
        $inputs = $request->all();
        
        $option->name = $inputs['name'];
        $option->price = $inputs['price'];
        $option->description = $inputs['description'];
        $option->update();

        return response()->json(["res" => [
            "code" => 200,
            "data" => new OptionResource($option)
        ]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Option $option
     * @return \Illuminate\Http\Response
     */
    public function destroy(Option $option)
    {
        $option->delete();

        return response()->json(["res" => [
            "code" => 200,
            "message" => "Option supprimée avec succès !"
        ]]);
    }
}
