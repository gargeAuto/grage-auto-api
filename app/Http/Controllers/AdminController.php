<?php

namespace App\Http\Controllers;

use \App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\SignupRequest;

class AdminController extends Controller
{

    public function addEngineer(SignupRequest $request)
    {


        $data = $request->validated();
        /**
         *  @var \App\Models\User $user 
         */
        $engineer = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => bcrypt($data["password"]),
            "role" => "technicien",

        ]);

        //error_log(var_export($engeener,true));

        return response($engineer);
    }
}
