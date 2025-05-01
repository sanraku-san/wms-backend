<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
     /**
     * Display a listing of the resource.
     **/
    public function index()
    {
        $products = Product::with('category')->get();
            return $this->Success($products);
    }
//filter
    public function showByPriceAsc()
    {
        $products = Product::with('category')->orderBy('price', 'asc')->get() ;
            return $this->Success($products);
    } 
    public function showByPriceDesc()
    {
        $products = Product::with('category')->orderBy('price', 'desc')->get() ;
            return $this->Success($products);
    } 
    public function showByCategory()
    {
        $products = Product::with('category')->orderBy('category_id', 'asc')->get() ;
            return $this->Success($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
    
        $inputs["name"] = $this->Sanitizer($inputs["name"]);

        $validator = validator()->make($request->all(), [
            "name" => "required|max:255|unique:products|string",
            "description" => "required|max:255|string",
            "price" => "required|numeric|max:999999999|min:0",
            // "image" => "required|mimes:jpg,jpeg,png,jfif|image",
            "barcode" => "required|string|max:255|unique:products",
            "category_id" => "required|exists:categories,id",
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }

        $products = Product::create($request->all());
        return $this->Created($products);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = Product::find($id);
        if(empty($products)){
            return $this->NotFound();
        }

        $products->category();

        return $this->Success($products);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $products = Product::find($id);
        if (!$products) {
            return $this->NotFound();
        }

        $inputs = $request->all();

        $inputs["name"] = $this->Sanitizer($inputs["name"]);
        if (empty($inputs["name"])) {
            unset($inputs["name"]);
        }

        $validator = validator()->make($request->all(), [
            "name" => "sometimes|string|max:64|unique:products,name," . $id, // Adjusted alpha_dash and min length
            "description" => "sometimes|string|max:255",
            "price" => "sometimes|numeric|max:999999999|min:0",
            // "image" => "sometimes|mimes:jpg,jpeg,png,jfif|image",
            "barcode" => "sometimes|string|max:255|unique:products,barcode," . $id,
            "category_id" => "sometimes|exists:categories,id",
        ]);
        
        if ($validator->fails()) {
            Log::error('Product Update Validation Failed:', $validator->errors()->all());
            return $this->BadRequest($validator);
        }

        try {
            $validatedData = $validator->validated();
            $products->update($validatedData);
            Log::info('Product Updated:', $products->toArray());
            return $this->Success($products);
        } catch (\Exception $e) {
            Log::error('Error updating product:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return $this->ServerError('Failed to update product.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $products = Product::find($id);
        if(!$products){
            return $this->NotFound();
        }

        $products->delete();
        return $this->Success($products, "Deleted");
    }


    public function filter(Request $request)
    {
        $query = Product::query();
    
        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
    
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
    
        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }
    
        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }
    
        $products = $query->with('category')->get();
    
        // Debugging: Log the query and results
        \Log::info('Filter Query:', ['query' => $query->toSql()]);
        \Log::info('Filter Results:', ['products' => $products]);
    
        if ($products->isEmpty()) {
            return $this->Success([], "No products found for the given filter criteria.");
        }
    
        return $this->Success($products);
    }
}



