<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Exception};
use App\Http\Resources\{ExceptionResource};
use Illuminate\Support\Facades\Validator;

class ExceptionController extends Controller
{
    /**
     * Show exceptions.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $exceptions = Exception::all();

        return response()->json(["success" => ExceptionResource::collection($exceptions)]);
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
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Create new Exception instance
        $inputs = $request->all();

        $exception = new Exception();
        $exception->title = $inputs['title'];
        $exception->start_date = $inputs['start_date'];
        $exception->end_date = $inputs['end_date'];
        $exception->save();

        return response()->json(["success" => new ExceptionResource($exception)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exception $exception)
    {
        $exception->delete();

        return response()->json(["success" => "Exception supprimée avec succès !"]);
    }
}
