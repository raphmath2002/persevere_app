<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Pension};

class PensionController extends Controller
{
    /**
     * Show pensions.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pensions = Pension::all();
        return response()->json($pensions);
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
            'price' => 'required|numeric',
            'description' => 'required|string|max:2048',
        ]);

        // Create new Pension instance
        $pension = new Pension();
        $pension->name = $validatedData['name'];
        $pension->price = $validatedData['price'];
        $pension->description = $validatedData['description'];
        $pension->save();

        return response()->json('Pension ajoutée avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pension $pension
     * @return \Illuminate\Http\Response
     */
    public function edit(Pension $pension)
    {
        return response()->json($pension);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pension $pension
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pension $pension)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string|max:2048',
        ]);

        // Update Pension
        $pension->name = $validatedData['name'];
        $pension->price = $validatedData['price'];
        $pension->description = $validatedData['description'];
        $pension->update();

        return response()->json('Pension mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pension $pension
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pension $pension)
    {
        $pension->delete();

        return response()->json('Pension supprimée avec succès !');
    }
}
