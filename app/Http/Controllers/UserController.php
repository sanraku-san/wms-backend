<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        if(!request()->user()->can('index users')){
            return $this->Forbidden();
        }

        $users = User::with("profile")->get();
        return $this->Success($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!request()->user()->can('create user')){
            return $this->Forbidden();
        }

        $inputs = $request->all();
    
        $inputs["first_name"] = $this->Sanitizer($inputs["first_name"]);
        $inputs["last_name"] = $this->Sanitizer($inputs["last_name"]);
    
    
        $validator = validator()->make($inputs, [
        "username" => "required|alpha_dash|unique:users|min:4|max:32",
        "email" => "required|email|unique:users,email|min:8|max:64",
        "password" => "required|string|min:8",
        "role_id" => "required|exists:roles,id",
        "first_name" => "required|alpha|min:2|max:32",
        "last_name" => "required|alpha|min:2|max:32",
        "contact_number" => "required|numeric|digits_between:10,12",
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }
    
        $user = User::create($validator->validated());
    
        $user->profile()->create($validator->validated());
    
        return $this->Created($user);
        }
    
        /**
         * Display the specified resource.
         */
    public function show(string $id)
    {
        if(!request()->user()->can('view user')){
            return $this->Forbidden();
        }

        $users = User::find($id);
        
        $users->profile;
        
        if(empty($users)){
            return $this->NotFound();
        }
        return $this->Success($users,);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!request()->user()->can('update user')){
            return $this->Forbidden();
        }

        $user = User::find($id);
        if(!$user){
            return $this->NotFound();
        }
        
        $inputs = $request->all();
        
        $inputs["first_name"] = $this->Sanitizer($inputs["first_name"] ?? "");
        $inputs["last_name"] = $this->Sanitizer($inputs["last_name"] ?? "");

        if(empty($inputs["first_name"]))
            unset($inputs["first_name"]);

        if(empty($inputs["last_name"]))
            unset($inputs["last_name"]);
        
        $validator = validator()->make($inputs, [
        "username" => "sometimes|alpha_dash|unique:users,username,$id|min:4|max:32",
        "email" => "sometimes|email|unique:users,email,$id|min:8|max:64",
        "password" => "sometimes|string|min:8",
        "first_name" => "sometimes|alpha|min:2|max:32",
        "last_name" => "sometimes|alpha|min:2|max:32",
        "contact_number" => "sometimes|numeric|digits_between:10,12",
        ]);

    if($validator->fails()){
        return $this->BadRequest($validator);
    }

    $user->update($validator->validated());

    $user->profile->update($validator->validated());

    return $this->Success($user,$user->profile());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!request()->user()->can('delete user')){
            return $this->Forbidden();
        }

        $user = User::find($id);
        if(!$user){
            return $this->NotFound();
        }

        $user->delete();
        return $this->Success($user, "Deleted");
    }
}