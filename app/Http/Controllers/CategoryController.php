<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
     /**
     * Display a listing of the resource.
     **/
    public function index()
    {
        $categories = Category::all();
            return $this->Success($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "name" => "required|alpha_dash|unique:categories|min:4|max:64",
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }

        $categories = Category::create($request->all());
        return $this->Created($categories);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categories = Category::find($id);
        if(empty($categories)){
            return $this->NotFound();
        }

        $categories->products;

        return $this->Success($categories);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categories = Category::find($id);
        if(!$categories){
            return $this->NotFound();
        }

        $validator = validator()->make($request->all(), [
            "name" => "sometimes|alpha_dash|unique:categories,name,$id|min:4|max:64",
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }

        $categories->update($validator->validated());
        return $this->Success($categories);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categories = Category::find($id);
        if(!$categories){
            return $this->NotFound();
        }

        $categories->delete();
        return $this->Success($categories, "Deleted");
    }
}
