<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
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

    $users = User::with(['profile', 'roles'])->get();

    foreach ($users as $user) {
        if ($user->image) {
            $user->image = asset($user->image);
        }
        if ($user->profile && $user->profile->image) {
            $user->profile->image = asset($user->profile->image);
        }
    }

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
        "role_id" => "required",
        "first_name" => "required|alpha|min:2|max:32",
        "last_name" => "required|alpha|min:2|max:32",
        "image" => "nullable|mimes:jpg,jpeg,png,jfif,webp|image|max:8192",
        "contact_number" => "required|numeric|digits_between:10,12",
    ]);

    if($validator->fails()){
        return $this->BadRequest($validator);
    }
    $data = $validator->validated();

    // Handle image upload
    if ($request->hasFile('image')) {
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('/images/users/'), $imageName);
        $data['image'] = 'images/users/' . $imageName;
    }

    $user = User::create($data);
    $user->profile()->create($data);

    if(request()->has("role_id")){
        $role = Role::find($request->input("role_id"));
        if ($role) {
            $user->assignRole($role->name);
        } else {
            return $this->BadRequest("Invalid role_id provided.");
        }
    }

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
        
        $users->profile->roles;
        
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
        "image" => "nullable|mimes:jpg,jpeg,png,jfif,webp|image|max:8192",
    ]);

    if($validator->fails()){
        return $this->BadRequest($validator);
    }

    $data = $validator->validated();

    // Handle image upload
    if ($request->hasFile('image')) {
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('/images/users/'), $imageName);
        $data['image'] = 'images/users/' . $imageName;
    }
    $user->update($data);
    if ($user->profile) {
        $user->profile->update($data);
    }

    return $this->Success($user, $user->profile());
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
        
        $user->profile()->delete();
        $user->delete();
        return $this->Success($user, "Deleted");
    }
    public function me()
{
    $user = Auth::user();
    if (!$user) {
        return $this->NotFound("User not found.");
    }
    $user->load('profile')->roles;

    if ($user->image) {
        $user->image = asset($user->image);
    }
    if ($user->profile && $user->profile->image) {
        $user->profile->image = asset($user->profile->image);
    }

    return $this->Success($user);
}

}