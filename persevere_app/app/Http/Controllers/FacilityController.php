<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Facility};
use App\Http\Resources\FacilityResource;

class FacilityController extends Controller
{
    /**
     * Show facilities.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $facilities = Facility::all();
        return response()->json(["success" => FacilityResource::collection($facilities)]);
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
            'description' => 'required|string|max:2048',
            'max_customer_allowed' => 'required|integer',
        ]);

        // Create new Facility instance
        $facility = new Facility();
        $facility->name = $validatedData['name'];
        $facility->description = $validatedData['description'];
        $facility->max_customer_allowed = $validatedData['max_customer_allowed'];
        $facility->save();

        return response()->json('Equipement ajouté avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facility $facility
     * @return \Illuminate\Http\Response
     */
    public function edit(Facility $facility)
    {
        return response()->json($facility);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facility $facility
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facility $facility)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2048',
            'max_customer_allowed' => 'required|integer',
        ]);

        // Update Facility
        $facility->name = $validatedData['name'];
        $facility->description = $validatedData['description'];
        $facility->max_customer_allowed = $validatedData['max_customer_allowed'];
        $facility->update();

        return response()->json('Equipement mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facility $facility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facility $facility)
    {
        $facility->delete();

        return response()->json('Equipement supprimé avec succès !');
    }
}
