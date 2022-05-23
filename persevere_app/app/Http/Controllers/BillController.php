<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Bill};
use App\Http\Resources\{BillResource};
use Illuminate\Support\Facades\Validator;
use Auth;

class BillController extends Controller
{
    /**
     * Show bills.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $bills = Bill::all();

        return response()->json(["success" => BillResource::collection($bills)]);
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
            'number' => 'required|string|max:255',
            'start_date' => 'required|date',
            'pricing' => 'required|float',
        ]);

        if($validator->fails()){
            return response()->json(["res" => [
                "code" => 400,
                "error" => $validator->errors()
            ]]);
        }

        // Create new Bill instance
        $inputs = $request->all();

        $bill = new Bill();
        $bill->number = $inputs['number'];
        $bill->start_date = $inputs['start_date'];
        $bill->pricing = $inputs['pricing'];
        $bill->user_id = Auth::user()->id;
        $bill->save();

        return response()->json(["res" => [
            "code" => 200,
            "data" => new BillResource($bill)
        ]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bill $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        return response()->json(["res" => [
            "code" => 200,
            "data" => new BillResource($bill)
        ]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bill $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|string|max:255',
            'start_date' => 'required|date',
            'pricing' => 'required|float',
        ]);

        if($validator->fails()){
            return response()->json(["res" => [
                "code" => 400,
                "error" => $validator->errors()
            ]]);
        }

        // Update Bill
        $inputs = $request->all();
        
        $bill->number = $inputs['number'];
        $bill->start_date = $inputs['start_date'];
        $bill->pricing = $inputs['pricing'];
        $bill->update();

        return response()->json(["res" => [
            "code" => 200,
            "data" => new BillResource($bill)
        ]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        $bill->delete();

        return response()->json(["res" => [
            "code" => 200,
            "message" => "Facture supprimée avec succès !"
        ]]);
    }
}
