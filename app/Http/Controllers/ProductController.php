<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
     /**
     * Display a listing of the resource by category.
     **/
    public function index()
    {
        if(!request()->user()->can('index products')){
            return $this->Forbidden();
        }

        $products = Product::with('category')->get();
        if ($products->isEmpty()) {
            return $this->NotFound();
        }
        return $this->Success($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!request()->user()->can('create product')){
            return $this->Forbidden();
        }

        $inputs = $request->all();
    
        $inputs["name"] = $this->Sanitizer($inputs["name"]);

        $validator = validator()->make($request->all(), [
            "name" => "required|max:255|unique:products|string",
            "description" => "required|max:255|string",
            "price" => "required|numeric|max:999999999|min:0",
            "image" => "required|mimes:jpg,jpeg,png,jfif,webp|image|max:8192",
            "barcode" => "required|string|max:255|unique:products",
            "category_id" => "required|exists:categories,id",
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }

        $imageName = time().'.'.$request->image->extension();

        $request->image->move(public_path('/images/products/'),$imageName);

        $products = new Product();

        $products->name = $inputs["name"];
        $products->description = $inputs["description"];
        $products->price = $inputs["price"];
        $products->image = 'images/products/'.$imageName;
        $products->barcode = $inputs["barcode"];
        $products->category_id = $inputs["category_id"];
        $products->save();

        return $this->Created($products);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!request()->user()->can('view product')){
            return $this->Forbidden();
        }
        $products = Product::find($id);
        if(empty($products)){
            return $this->NotFound();
        }

        $products->category();

        return $this->Success($products);
    }
    
    /**
     * Display the specified resource by category.
     */
    public function showByCategory(string $category_id)
    {
    $products = Product::with('category')->where('category_id', $category_id)->get();
    if ($products->isEmpty()) {
        return $this->NotFound();
    }

    return $this->Success($products);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!request()->user()->can('update product')){
            return $this->Forbidden();
        }

        $products = Product::find($id);
        if(!$products){
            return $this->NotFound();
        }

        $inputs = $request->all();
    
        $inputs["name"] = $this->Sanitizer($inputs["name"]);
        if(empty($inputs["name"]))
            unset($inputs["name"]);

        $validator = validator()->make($request->all(), [
            "name" => "sometimes|alpha_dash|unique:products,name,$id|min:4|max:64",
            "description" => "sometimes|max:255|string",
            "price" => "sometimes|numeric|max:999999999|min:0",
            "image" => "sometimes|mimes:jpg,jpeg,png,jfif|image|max:8192",
            "barcode" => "sometimes|string|max:255|unique:products,barcode,$id|",
            "category_id" => "sometimes|exists:categories,id",
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }

        $products->update($validator->validated());
        return $this->Success($products);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!request()->user()->can('delete product')){
            return $this->Forbidden();
        }

        $products = Product::find($id);
        if(!$products){
            return $this->NotFound();
        }

        $products->delete();
        return $this->Success($products, "Deleted");
    }
}



