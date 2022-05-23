<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\EmailVerification;
use App\Http\Resources\UserResource;
use Auth;

class LoginController extends Controller
{
    public function verifCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'email' => 'required|string'
        ]);

        $input = $request->all();

        $user = User::where('email', $input['email'])->first();
        $code = EmailVerification::where('user_id', $user->id)->first();

        if(!isset($user) || !isset($code) || $code->code != $input['code']) {
            return response()->json(["error" => "Code de vérification erroné !"]);
        }

        $user->api_token = Str::random(50);
        $user->save();

        return response()->json(["success" => new UserResource($user)]);
    }

    public function login(Request $request)
    {
        //Validation des inputs
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        //SI validation échoue, on retournes les champs erronés
        if ($validator->fails()) {
            return response()->json(["input_error" => $validator->errors()]);
        }

        //On place tous les champs dans une variable input
        $input = $request->all();

        //On récupère l'user concené
        $user = User::where('email', $input['email'])->first();

        //Si l'utilisateur n'existe pas
        if (!isset($user)) return response()->json(["error" => "Identifiants incorrects"]);
        

        if(!isset($user->password)) {
            $old_verif_code = EmailVerification::where('user_id', $user->id)->first();

            if(isset($old_verif_code)) {
                $old_verif_code->delete();
            }

            $verification_code = Str::random(10);

            $new_verif = new EmailVerification();
            $new_verif->code = $verification_code;
            $new_verif->user_id = $user->id;
            $new_verif->save();

            return response()->json(["success" => $new_verif->code]);
        }

        // On check la validité du mot de passe avec celui en base
        if (Hash::check($input['password'], $user->password)) {
            // création d'un nouveau token
            $new_token = Str::random(50);

            //Stockage du token en base et sauvegarde de l'user
            $user->api_token = $new_token;
            $user->save();

            //On retourne l'user connecté
            return response()->json(["success" => new UserResource($user)]);
        } else return response()->json(["error" => "identifiants incorrects"]);
    }
}
