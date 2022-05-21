<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Option};

class OptionController extends Controller
{
    /**
     * Show options.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $options = Option::all();
        return response()->json($options);
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
            'name' => 'required|string|max:255',
        ]);

        // Create new Option instance
        $option = new Option();
        $option->name = $validatedData['name'];
        $option->save();

        return response()->json('Option ajoutée avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Option $option
     * @return \Illuminate\Http\Response
     */
    public function edit(Option $option)
    {
        return response()->json($option);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Option $option
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Option $option)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update Option
        $option->name = $validatedData['name'];
        $option->update();

        return response()->json('Option mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Option $option
     * @return \Illuminate\Http\Response
     */
    public function destroy(Option $option)
    {
        $option->delete();

        return response()->json('Option supprimée avec succès !');
    }
}
