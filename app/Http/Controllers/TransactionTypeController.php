<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction_Type;

class TransactionTypeController extends Controller
{
     /**
     * Display a listing of the resource.
     **/
    public function index()
    {
        $transactionType = Transaction_Type::all();
        
        return $this->Success($transactionType);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "name" => "required|alpha_dash|unique:transaction__types|min:4|max:64",
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }

        $transactionType = Transaction_Type::create($request->all());
        return $this->Created($transactionType);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transactionType = Transaction_Type::find($id);
        if(empty($transactionType)){
            return $this->NotFound();
        }
        return $this->Success($transactionType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transactionType = Transaction_Type::find($id);
        if(!$transactionType){
            return $this->NotFound();
        }

        $validator = validator()->make($request->all(), [
            "name" => "sometimes|alpha_dash|unique:transaction__types,name,$id|min:4|max:64",
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }

        $transactionType->update($validator->validated());
        return $this->Success($transactionType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transactionType = Transaction_Type::find($id);
        if(!$transactionType){
            return $this->NotFound();
        }

        $transactionType->delete();
        return $this->Success($transactionType, "Deleted");
    }
}
