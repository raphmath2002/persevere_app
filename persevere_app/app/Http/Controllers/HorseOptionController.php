<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Horse,Option,HorseOption};
use App\Http\Resources\{HorseResource,OptionResource,HorseOptionResource};
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class HorseOptionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request, Horse $horse, Option $option)
    {
        $validator = Validator::make($request->all(), [
            'subscribe_date' => 'required|date',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Create new HorseOption instance
        $inputs = $request->all();

        $horseOption = new HorseOption();
        $horseOption->subscribe_date = $inputs['subscribe_date'];
        $horseOption->horse_id = $horse->id;
        $horseOption->option_id = $option->id;
        $horseOption->save();

        return response()->json(["success" => new HorseOptionResource($horseOption)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HorseOption $horseOption
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe(Request $request, HorseOption $horseOption)
    {
        // Delete HorseOption instance
        $horseOption->unsubscribe_date = Carbon::now();
        $horseOption->update();

        return response()->json(["success" => "Désabonnement de l'option avec succès !"]);
    }
}
