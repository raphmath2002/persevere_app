<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Ticket};
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
        return response()->json($tickets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:2048',
        ]);

        // Create new Ticket instance
        $ticket = new Ticket();
        $ticket->title = $validatedData['title'];
        $ticket->content = $validatedData['content'];
        $ticket->user_id = Auth::user()->id;
        $ticket->save();

        return response()->json('Ticket ajouté avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        return response()->json($ticket);
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
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:2048',
        ]);

        // Update Ticket
        $ticket->title = $validatedData['title'];
        $ticket->content = $validatedData['content'];
        $ticket->update();

        return response()->json('Ticket mis à jour avec succès !');
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

        return response()->json('Ticket supprimé avec succès !');
    }
}
