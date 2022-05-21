<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Visit};

class VisitController extends Controller
{
    /**
     * Show visits.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $visits = Visit::all();
        return response()->json($visits);
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

        // Create new Visit instance
        $visit = new Visit();
        $visit->name = $validatedData['name'];
        $visit->save();

        return response()->json('Visite ajoutée avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visit $visit
     * @return \Illuminate\Http\Response
     */
    public function edit(Visit $visit)
    {
        return response()->json($visit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visit $visit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visit $visit)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update Visit
        $visit->name = $validatedData['name'];
        $visit->update();

        return response()->json('Visite mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visit $visit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visit $visit)
    {
        $visit->delete();

        return response()->json('Visite supprimée avec succès !');
    }
}
