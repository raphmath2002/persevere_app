<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User};
use App\Http\Resources\{UserResource};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Image;
use Carbon\Carbon;

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

        return response()->json(["success" => UserResource::collection($users)]);
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
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'birth_date' => 'required',
            'email' => 'required|string|max:255|unique:users,email',
            'phone' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'postal_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'storage_path' => 'required|string',
            'auth_level' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Create new User instance
        $inputs = $request->all();

        $user = new User();
        $user->name = $inputs['name'];
        $user->firstname = $inputs['firstname'];
        $user->birth_date = $inputs['birth_date'];
        $user->email = $inputs['email'];
        $user->password = null;
        $user->phone = $inputs['phone'];
        $user->postal_code = $inputs['postal_code'];
        $user->postal_address = $inputs['postal_address'];
        $user->city = $inputs['city'];
        $user->country = $inputs['country'];
        $user->auth_level = $inputs['auth_level'];

        // Photo storage
        $make_image = Image::make($inputs['storage_path']);
        $type = $make_image->mime();
        $extension_path = explode("/", $type)[1];

        $url = 'img_uploads/img_users/'.trim($user->firstname).'_'.trim($user->name).'.'.$extension_path.'';
        $make_image->save(public_path($url));
        $user->storage_path = URL::asset($url);

        $user->save();

        return response()->json(["success" => new UserResource($user)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return response()->json(["success" => new UserResource($user)]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'birth_date' => 'required',
            'email' => 'required|string|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'postal_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'storage_path' => 'string'
        ]);

        if($validator->fails()){
            return response()->json(["input_arror" => $validator->errors()]);
        }

        // Update User
        $inputs = $request->all();
        
        $user->name = $inputs['name'];
        $user->firstname = $inputs['firstname'];
        $user->birth_date = $inputs['birth_date'];
        $user->email = $inputs['email'];
        $user->phone = $inputs['phone'];
        $user->postal_code = $inputs['postal_code'];
        $user->postal_address = $inputs['postal_address'];
        $user->city = $inputs['city'];
        $user->country = $inputs['country'];

        if(isset($inputs['storage_path'])) {
            $make_image = Image::make($inputs['storage_path']);
            $type = $make_image->mime();
            $extension_path = explode("/", $type)[1];

            $url = 'img_uploads/img_users/'. Str::random(15) .'.'.$extension_path.'';
            $make_image->save(public_path($url));
            $user->storage_path = URL::asset($url);

            // Delete old photo
            if(file_exists($inputs['storage_path'])){
                unlink($inputs['storage_path']);
            }
        }
        
        $user->update();

        return response()->json(["success" => new UserResource($user)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update_photo(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'storage_path' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Update photo
        $inputs = $request->all();

        $make_image = Image::make($inputs['storage_path']);
        $type = $make_image->mime();
        $extension_path = explode("/", $type)[1];

        $url = 'img_uploads/img_users/'. Str::random(15) .'.'.$extension_path.'';
        $make_image->save(public_path($url));
        $user->storage_path = URL::asset($url);

        // Delete old photo
        if(file_exists($inputs['storage_path'])){
            unlink($inputs['storage_path']);
        }

        $user->update();

        return response()->json(["success" => new UserResource($user)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|string|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&.])[A-Za-z\d@$!%*#?&.]{8,}$/', // 1 leter, 1 number, 1 special caracter, 8 caracters min
            'confirm_password' => 'required|same:new_password',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Update password
        $inputs = $request->all();

        $old_password = $inputs['old_password'];
        $new_password = Hash::make($inputs['new_password']);

        if(!isset($user->password))
        {
            $user->password = $new_password;
            $user->update();

            return response()->json(["success" => new UserResource($user)]);
        }

        if(Hash::check($old_password, $user->password)){ // Compare old password
            $user->password = $new_password;
            $user->update();
        } else {
            return response()->json(["error" => "Identifiants invalide !"]);
        }

        return response()->json(["success" => "Mot de passe changé"]);
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

        return response()->json(["success" => "Utilisateur supprimé avec succès !"]);
    }
}
