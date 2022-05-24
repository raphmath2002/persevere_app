<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Message};
use App\Http\Resources\{MessageResource};
use Illuminate\Support\Facades\Validator;
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

        return response()->json(["success" =>HorseResource::collection($horses)]);
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
            'content' => 'required|string|max:2048',
            'ticket_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Create new Message instance
        $inputs = $request->all();

        $message = new Message();
        $message->content = $inputs['content'];
        $message->ticket_id = $inputs['ticket_id'];
        $message->user_id = Auth::user()->id;
        $message->save();

        return response()->json(["success" => new MessageResource($message)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        return response()->json(["success" => new MessageResource($message)]);
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
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Update Message
        $inputs = $request->all();
        
        $message->content = $inputs['content'];
        $message->update();

        return response()->json(["success" => new MessageResource($message)]);
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

        return response()->json(["success" => "Message supprimé avec succès !"]);
    }
}
