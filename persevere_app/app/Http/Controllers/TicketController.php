<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Ticket, User};
use App\Http\Resources\{TicketResource};
use Illuminate\Support\Facades\Validator;
use Auth;

class TicketController extends Controller
{
    /**
     * Show tickets.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tickets = Ticket::all();

        return response()->json(["success" => TicketResource::collection($tickets)]);
    }

    public function getTicketByUser(User $user)
    {
        $tickets = Ticket::where('user_id', $user->id)->get();

        return response()->json(['success' => TicketResource::collection($tickets)]);
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
            'title' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Create new Ticket instance
        $inputs = $request->all();

        $ticket = new Ticket();
        $ticket->title = $inputs['title'];
        $ticket->user_id = Auth::user()->id;
        $ticket->save();

        return response()->json(["success" => new TicketResource($ticket)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        return response()->json(["success" => new TicketResource($ticket)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Update Ticket
        $inputs = $request->all();
        
        $ticket->title = $inputs['title'];
        $ticket->update();

        return response()->json(["success" => new TicketResource($ticket)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return response()->json(["success" => "Ticket supprimé avec succès !"]);
    }
}
