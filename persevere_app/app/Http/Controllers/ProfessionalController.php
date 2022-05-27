<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Professional};
use App\Http\Resources\{ProfessionalResource};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Image;
use Carbon\Carbon;

class ProfessionalController extends Controller
{
    /**
     * Show professionals.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $professionals = Professional::all();

        return response()->json(["success" => ProfessionalResource::collection($professionals)]);
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
            'birth_date' => 'required|date',
            'email' => 'required|string|max:255|unique:professionals,email',
            'phone' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'postal_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'storage_path' => 'required|string',
            'profession' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Create new Professional instance
        $inputs = $request->all();

        $professional = new Professional();
        $professional->name = $inputs['name'];
        $professional->firstname = $inputs['firstname'];
        $professional->birth_date = new Carbon($inputs['birth_date']);
        $professional->email = $inputs['email'];

        $professional->phone = $inputs['phone'];
        $professional->postal_code = $inputs['postal_code'];
        $professional->postal_address = $inputs['postal_address'];
        $professional->city = $inputs['city'];
        $professional->country = $inputs['country'];
        $professional->profession = $inputs['profession'];

        // Photo storage
        $make_image = Image::make($inputs['storage_path']);
        $type = $make_image->mime();
        $extension_path = explode("/", $type)[1];

        $url = 'img_uploads/img_professionals/'.trim($professional->firstname).'_'.trim($professional->name).'.'.$extension_path.'';
        $make_image->save(public_path($url));
        $professional->storage_path = URL::asset($url);

        $professional->save();

        return response()->json(["success" => new ProfessionalResource($professional)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Professional $professional
     * @return \Illuminate\Http\Response
     */
    public function edit(Professional $professional)
    {
        return response()->json(["success" => new ProfessionalResource($professional)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Professional $professional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Professional $professional)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'birth_date' => 'required',
            'email' => 'required|string|max:255|unique:professionals,email,' . $professional->id,
            'phone' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'postal_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }


        // Update Professional
        $inputs = $request->all();
        
        $professional->name = $inputs['name'];
        $professional->firstname = $inputs['firstname'];
        $professional->birth_date = new Carbon($inputs['birth_date']);
        $professional->email = $inputs['email'];
        $professional->phone = $inputs['phone'];
        $professional->postal_code = $inputs['postal_code'];
        $professional->postal_address = $inputs['postal_address'];
        $professional->city = $inputs['city'];
        $professional->country = $inputs['country'];
        $professional->profession = $inputs['profession'];
        $professional->update();

        return response()->json(["success" => new ProfessionalResource($professional)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Professional $professional
     * @return \Illuminate\Http\Response
     */
    public function update_photo(Request $request, Professional $professional)
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

        $url = 'img_uploads/img_professionals/'.trim($professional->firstname).'_'.trim($professional->name).'.'.$extension_path.'';
        $make_image->save(public_path($url));
        $professional->storage_path = URL::asset($url);

        // Delete old photo
        if(file_exists($inputs['storage_path'])){
            unlink($inputs['storage_path']);
        }

        $professional->update();

        return response()->json(["success" => new ProfessionalResource($professional)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Professional $professional
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request, Professional $professional)
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

        if(Hash::check($old_password, $professional->password)){ // Compare old password
            $professional->password = $new_password;
            $professional->update();
        }

        return response()->json(["success" => new ProfessionalResource($professional)]);
    }

    public function getProfessions() 
    {
        $professions = [];

        $professionals =  Professional::all();

        foreach ($professionals as $pro) {
            $profession = strtolower($pro->profession);

            if(!in_array($profession, $professions)) {
                array_push($professions, $profession);
            }
        }

        return response()->json(['success' => $professions]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Professional $professional
     * @return \Illuminate\Http\Response
     */
    public function destroy(Professional $professional)
    {
        $professional->delete();

        return response()->json(["success" => "Professionnel supprimé avec succès !"]);
    }
}
