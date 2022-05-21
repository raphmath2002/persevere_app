<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User};
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Show users.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
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
            'firstname' => 'required|string|max:255',
            'birth' => 'required|date',
            'email' => 'required|string|max:255|unique:users,email',
            'password' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'postcode' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'avatar_path' => 'required|string|max:255',
            'role_id' => 'required|integer',
        ]);

        // Create new User instance
        $user = new User();
        $user->name = $validatedData['name'];
        $user->firstname = $validatedData['firstname'];
        $user->birth = $validatedData['birth'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->phone = $validatedData['phone'];
        $user->postcode = $validatedData['postcode'];
        $user->city = $validatedData['city'];
        $user->country = $validatedData['country'];
        $user->avatar_path = $validatedData['avatar_path'];
        $user->role_id = $validatedData['role_id'];
        $user->save();

        return response()->json('Utilisateur ajouté avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'birth' => 'required|date',
            'phone' => 'required|string|max:255',
            'postcode' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        // Update User
        $user->name = $validatedData['name'];
        $user->firstname = $validatedData['firstname'];
        $user->birth = $validatedData['birth'];
        $user->phone = $validatedData['phone'];
        $user->postcode = $validatedData['postcode'];
        $user->city = $validatedData['city'];
        $user->country = $validatedData['country'];
        $user->update();

        return response()->json('Utilisateur mis à jour avec succès !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function updatePhoto(Request $request, User $user)
    {
        // Update avatar path

        return response()->json('Photo de profil mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json('Utilisateur supprimé avec succès !');
    }
}
