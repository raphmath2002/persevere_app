<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Horse};

class HorseController extends Controller
{
    /**
     * Show horses.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $horses = Horse::all();
        return response()->json($horses);
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
            'size' => 'required|numeric|max:255',
            'weigth' => 'required|numeric|max:255',
            'birth_date' => 'required|date|max:255',
            'sire_code' => 'required|string|max:255',
            'ueln_code' => 'required|string|max:255',
            'birth_country' => 'required|string|max:255',
            'avatar_path' => 'required|string|max:255',
        ]);

        // Create new Horse instance
        $horse = new Horse();
        $horse->name = $validatedData['name'];
        $horse->size = $validatedData['size'];
        $horse->weigth = $validatedData['weigth'];
        $horse->birth_date = $validatedData['birth_date'];
        $horse->sire_code = $validatedData['sire_code'];
        $horse->ueln_code = $validatedData['ueln_code'];
        $horse->birth_country = $validatedData['birth_country'];
        $horse->avatar_path = $validatedData['avatar_path'];
        $horse->save();

        return response()->json('Cheval ajouté avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Horse $horse
     * @return \Illuminate\Http\Response
     */
    public function edit(Horse $horse)
    {
        return response()->json($horse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Horse $horse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Horse $horse)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|numeric|max:255',
            'weigth' => 'required|numeric|max:255',
            'birth_date' => 'required|date|max:255',
            'sire_code' => 'required|string|max:255',
            'ueln_code' => 'required|string|max:255',
            'birth_country' => 'required|string|max:255',
            'avatar_path' => 'required|string|max:255',
        ]);

        // Update Horse
        $horse->name = $validatedData['name'];
        $horse->size = $validatedData['size'];
        $horse->weigth = $validatedData['weigth'];
        $horse->birth_date = $validatedData['birth_date'];
        $horse->sire_code = $validatedData['sire_code'];
        $horse->ueln_code = $validatedData['ueln_code'];
        $horse->birth_country = $validatedData['birth_country'];
        $horse->avatar_path = $validatedData['avatar_path'];
        $horse->update();

        return response()->json('Cheval mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Horse $horse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Horse $horse)
    {
        $horse->delete();

        return response()->json('Cheval supprimé avec succès !');
    }
}
