<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Appointment};
use App\Http\Resources\{AppointmentResource};
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Show appointments.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $appointments = Appointment::all();

        return response()->json(["res" => [
            "code" => 200,
            "data" => AppointmentResource::collection($appointments)
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
            'duration' => 'required|integer',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'max_appointments' => 'required|integer',
            'professional_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(["res" => [
                "code" => 400,
                "error" => $validator->errors()
            ]]);
        }

        // Create new Appointment instance
        $inputs = $request->all();

        $appointment = new Appointment();
        $appointment->duration = $inputs['duration'];
        $appointment->price = $inputs['price'];
        $appointment->start_date = $inputs['start_date'];
        $appointment->max_appointments = $inputs['max_appointments'];
        $appointment->professional_id = $inputs['professional_id'];
        $appointment->save();

        return response()->json(["res" => [
            "code" => 200,
            "data" => new AppointmentResource($appointment)
        ]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        return response()->json(["res" => [
            "code" => 200,
            "data" => new AppointmentResource($appointment)
        ]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validator = Validator::make($request->all(), [
            'duration' => 'required|integer',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'max_appointments' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(["res" => [
                "code" => 400,
                "error" => $validator->errors()
            ]]);
        }

        // Update appointment
        $inputs = $request->all();
        
        $appointment->duration = $inputs['duration'];
        $appointment->price = $inputs['price'];
        $appointment->start_date = $inputs['start_date'];
        $appointment->max_appointments = $inputs['max_appointments'];
        $appointment->update();

        return response()->json(["res" => [
            "code" => 200,
            "data" => new AppointmentResource($appointment)
        ]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json(["res" => [
            "code" => 200,
            "message" => "Visite supprimée avec succès !"
        ]]);
    }
}
