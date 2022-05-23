<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Appointment,Horse,AppointmentHorse};
use App\Http\Resources\{AppointmentResource,HorseResource,AppointmentHorseResource};
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AppointmentHorseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Appointment $appointment, Horse $horse)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2048',
            'start_date' => 'required|date',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }
        
        $inputs = $request->all();

        // Check if nobody reserved the date
        $selected_start_date = Carbon::parse($inputs['start_date']);
        $selected_end_date = Carbon::parse($inputs['start_date'])->addMinutes($appointment->duration);

        $appointment_horse = AppointmentHorse::where([['appointment_id', '=', $appointment->id],['status','=','waiting']])->orWhere([['appointment_id', '=', $appointment->id],['status','=','accepted']])->get();

        foreach($appointment_horse as $app_horse){
            $start_date = Carbon::parse($app_horse->start_date);
            $end_date = Carbon::parse($app_horse->end_date);

            if(($start_date < $selected_start_date && $selected_start_date < $end_date) || ($start_date < $selected_end_date && $selected_end_date < $end_date)){
                return response()->json(["error" => "La date demandée se superpose à celle d'un autre rendez-vous."]);
            }
        }

        // Check date validity
        $start_date = Carbon::parse($appointment->start_date);
        $end_date = Carbon::parse($appointment->end_date);

        if($selected_start_date < $start_date){ // If selected date (start) < appointment start date
            return response()->json(["error" => "La date de début du rendez-vous ne respecte pas la plage horaires du professionnel."]);
        }
        elseif($selected_end_date > $end_date){ // If selected date (end) > appointment end date
            return response()->json(["error" => "La date de fin du rendez-vous ne respecte pas la plage horaires du professionnel."]);
        }

        // Create new AppointmentHorse instance
        $appointmentHorse = new AppointmentHorse();
        $appointmentHorse->title = $inputs['title'];
        $appointmentHorse->description = $inputs['description'];
        $appointmentHorse->start_date = $inputs['start_date'];
        $appointmentHorse->appointment_id = $appointment->id;
        $appointmentHorse->horse_id = $horse->id;
        $appointmentHorse->status = "waiting";

        $end_date = Carbon::parse($inputs['start_date']);
        $appointmentHorse->end_date = $end_date->addMinutes($appointment->duration);

        $appointmentHorse->save();

        return response()->json(["success" => new AppointmentHorseResource($appointmentHorse)]);
    }

    /**
     * Accept the specified resource from storage.
     *
     * @param  \App\Models\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request, AppointmentHorse $appointmentHorse)
    {
        // Update AppointmentHorse
        $appointmentHorse->status = "accepted";
        $appointmentHorse->update();

        return response()->json(["success" => "Rendez-vous accepté avec succès !"]);
    }

    /**
     * Refuse the specified resource from storage.
     *
     * @param  \App\Models\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function refuse(Request $request, AppointmentHorse $appointmentHorse)
    {
        $validator = Validator::make($request->all(), [
            'refuse_reason' => 'required|string|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Update AppointmentHorse
        $inputs = $request->all();

        $appointmentHorse->status = "refused";
        $appointmentHorse->observations = $inputs['refuse_reason'];
        $appointmentHorse->update();

        return response()->json(["success" => "Rendez-vous refusé avec succès !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request, AppointmentHorse $appointmentHorse)
    {
        $validator = Validator::make($request->all(), [
            'cancel_reason' => 'required|string|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Update AppointmentHorse
        $inputs = $request->all();

        $appointmentHorse->status = "canceled";
        $appointmentHorse->observations = $inputs['cancel_reason'];
        $appointmentHorse->update();

        return response()->json(["success" => "Rendez-vous annulé avec succès !"]);
    }

    /**
     * Close the specified resource from storage.
     *
     * @param  \App\Models\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function close(Request $request, AppointmentHorse $appointmentHorse)
    {
        $validator = Validator::make($request->all(), [
            'price' => 'required|numeric',
            'cares' => 'required|string|max:2048',
            'observations' => 'nullable|string|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Update AppointmentHorse
        $inputs = $request->all();

        $appointmentHorse->status = "ended";
        $appointmentHorse->price = $inputs['price'];
        $appointmentHorse->cares = $inputs['cares'];
        $appointmentHorse->observations = $inputs['observations'];
        $appointmentHorse->update();

        return response()->json(["success" => "Rendez-vous clôturé avec succès !"]);
    }
}