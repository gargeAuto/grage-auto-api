<?php

namespace App\Http\Controllers;
use \App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\SignupRequest;
class AdminController extends Controller
{

    public function addEngeener(SignupRequest $request){
        
 
    $data = $request ->validated();
    /**
     *  @var \App\Models\User $user 
    */
    $engeener = User::create([
        "name" => $data["name"],
        "email" => $data["email"],
        "password" => bcrypt($data["password"]),
        "role" => "technicien",
        
    ]);
    dd($engeener);
  
    return response($engeener);

    }
}