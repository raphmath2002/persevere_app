<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Horse,Pension,HorsePension};
use App\Http\Resources\{HorseResource,PensionResource,HorsePensionResource};
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class HorsePensionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request, Horse $horse, Pension $pension)
    {
        $validator = Validator::make($request->all(), [
            'subscribe_date' => 'required|date',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        $horsePension = HorsePension::where([['horse_id', '=', $horse->id], ['unsubscribe_date', '=', null]])->first();
        if(!is_null($horsePension)){
            return response()->json(["error" => "Le cheval est déjà rattaché à une pension en cours."]);
        }

        // Create new HorsePension instance
        $inputs = $request->all();

        $horsePension = new HorsePension();
        $horsePension->subscribe_date = $inputs['subscribe_date'];
        $horsePension->horse_id = $horse->id;
        $horsePension->pension_id = $pension->id;
        $horsePension->save();

        return response()->json(["success" => new HorsePensionResource($horsePension)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HorsePension $horsePension
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe(Request $request, HorsePension $horsePension)
    {
        // Delete HorsePension instance
        $horsePension->unsubscribe_date = Carbon::now();
        $horsePension->update();

        return response()->json(["success" => "Désabonnement de la pension avec succès !"]);
    }
}
