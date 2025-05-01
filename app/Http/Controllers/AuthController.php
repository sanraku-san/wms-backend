<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = validator()->make($request->all(), [
            "name" => "required|alpha_dash|min:4|max:64",
            "email" => "required|email|unique:users",
            "password" => "required|min:8",
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }

        $user = User::create($request->all());
        return $this->Created($user);
    }
    
    public function login(Request $request){

        $validator = validator()->make($request->all(), [
            "email" => "required",
            "password" => "required", 
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }

        if(!auth()->attempt($validator->validated())){
            return $this->Unauthorized("Invalid credentials!");
        };

        $user = auth()->user();

        $user -> token = $user->createToken("api")->plainTextToken;

        return $this->Success($user, "Logged in!");
    }
    public function logout(Request $request){
    {
        $request->user()->currentAccessToken()->delete();
        
        return $this->Success(null, "Logged out!");
    }
}

    public function CheckAuth(Request $request){
        $user = request()->user();
        if(!$user){
            return $this->Unauthorized();
        }   

        return $this->Success($user, "Authenticated!");
    }
}
