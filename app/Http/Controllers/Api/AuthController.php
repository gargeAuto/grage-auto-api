<?php

namespace App\Http\Controllers\Api;

use App\Notifications\InvoicePaid;


use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use Illuminate\Http\Request;
use \App\Models\User;
use App\Notifications\VerifyMail;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
     public function signUp(SignupRequest $request)
    {
        \Log::info($request->all());
        $data = $request->validated();
        /**
         *  @var \App\Models\User $user 
         */



        $user = User::create([
            "name" => $data["name"],
            "surname" => $data["surname"],
            "phone"=> $data["phone"],
            "email" => $data["email"],
            "password" => bcrypt($data["password"]),
        ]);

        // $notification = new InvoicePaid();

        // Envoi de la notification
        $notification = $user->notify(new VerifyMail($user));
        //  error_log(var_export($newUser,true));
        // \Log::info('InvoicePaid notification sent', $notification->toArray($user));
        //$token = $user->createToken("main")->plainTextToken;


        return response()->json([
    "message" => "Un email de vérification a été envoyé à votre adresse email. 
    Veuillez vérifier votre boîte de réception vaus spame et cliquer sur le lien de vérification pour activer votre compte.",
], 201);
    }

    public function login(LoginRequest $request)
    {
    
        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) {
            return response([
                "message" => "Provided email address or password is incorrect"
            ], 422);
        }
        /** @var User $user */
        $user = Auth::user();
        if(!$user->hasVerifiedEmail()){
            return response([
                "message" => "Veuillez vérifier votre adresse email avant de vous connecter."
            ], 403);
        }
        $token = $user->createToken("main")->plainTextToken;
        return response(compact("user", "token"));
    }

    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response('', 204);
    }
    public function verifyEmail(Request $request)
    {
        if (!$request->hasValidSignature()) {
            return  response([
                "message" => "lien inccorect ou expiré"
            ], 422);
        }
        $userId = $request->query('id');
        $user = User::findOrFail($userId);
        $user->email_verified_at = now();
        $user->save();
        $token = $user->createToken("main")->plainTextToken;
        return response()->json([
            "message" => "Votre adresse e-mail a été vérifiée avec succès.",
            "token" => $token
        ]);
    }
}
