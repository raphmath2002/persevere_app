<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Message,Ticket};
use Auth;

class MessageController extends Controller
{
    /**
     * Show messages.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $messages = Message::all();
        return response()->json($messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Ticket $ticket)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:2048',
        ]);

        // Create new Message instance
        $message = new Message();
        $message->content = $validatedData['content'];
        $message->ticket_id = $ticket->id;
        $message->user_id = Auth::user()->id;
        $message->save();

        return response()->json('Message ajouté avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        return response()->json($message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:2048',
        ]);

        // Update Message
        $message->content = $validatedData['content'];
        $message->update();

        return response()->json('Message mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->delete();

        return response()->json('Message supprimé avec succès !');
    }
}
