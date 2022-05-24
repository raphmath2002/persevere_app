<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Appointment,AppointmentHorse};
use App\Http\Resources\{AppointmentResource};
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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

        return response()->json(["success" => AppointmentResource::collection($appointments)]);
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
            'start_date' => 'required',
            'max_appointments' => 'required|integer',
            'professional_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Create new Appointment instance
        $inputs = $request->all();

        $appointment = new Appointment();
        $appointment->duration = $inputs['duration'];
        $appointment->start_date = new Carbon($inputs['start_date']);
        $appointment->max_appointments = $inputs['max_appointments'];
        $appointment->professional_id = $inputs['professional_id'];
        $appointment->status = "waiting";

        $end_date = Carbon::parse($inputs['start_date']);
        $appointment->end_date = $end_date->addMinutes($inputs['duration'] * $inputs['max_appointments']);

        $appointment->save();

        return response()->json(["success" => new AppointmentResource($appointment)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        return response()->json(["success" => new AppointmentResource($appointment)]);
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
            'start_date' => 'required',
            'max_appointments' => 'required|integer',
            'professional_id' => 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        $appointment_horse = AppointmentHorse::where([['appointment_id', '=', $appointment->id],['status','=','waiting'],['start_date','>',Carbon::now()]])->orWhere([['appointment_id', '=', $appointment->id],['status','=','accepted'],['start_date','>',Carbon::now()]])->get();

        // Cancel all appointment horse
        $inputs = $request->all();

        foreach($appointment_horse as $app_horse){
            $app_horse->status = "canceled";
            $app_horse->observations = "Mise à jour du rendez-vous, ce dernier ne correspond plus aux modalités de la prise de rendez-vous initiale.";
            $app_horse->update();
        }

        // Update Appointment
        $appointment->duration = $inputs['duration'];
        $appointment->start_date = new Carbon($inputs['start_date']);
        $appointment->max_appointments = $inputs['max_appointments'];
        $appointment->professional_id = $inputs['professional_id'];

        $end_date = Carbon::parse($inputs['start_date']);
        $appointment->end_date = $end_date->addMinutes($inputs['duration'] * $inputs['max_appointments']);

        $appointment->update();

        return response()->json(["success" => new AppointmentResource($appointment)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Appointment $appointment)
    {
        $validator = Validator::make($request->all(), [
            'cancel_reason' => 'required|string|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        $appointment_horse = AppointmentHorse::where([['appointment_id', '=', $appointment->id],['status','=','waiting'],['start_date','>',Carbon::now()]])->orWhere([['appointment_id', '=', $appointment->id],['status','=','accepted'],['start_date','>',Carbon::now()]])->get();

        // Cancel all appointment horse
        $inputs = $request->all();

        foreach($appointment_horse as $app_horse){
            $app_horse->status = "canceled";
            $app_horse->observations = $inputs['cancel_reason'];
            $app_horse->update();
        }

        // Update Appointment
        $appointment->status = "canceled";
        $appointment->cancel_reason = $inputs['cancel_reason'];
        $appointment->update();

        return response()->json(["success" => "Rendez-vous annulé avec succès !"]);
    }
}