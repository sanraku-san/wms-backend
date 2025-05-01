<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
     /**
     * Display a listing of the resource.
     **/
    public function index()
    {
        $transactions = Transaction::with('transaction_type')->with('user')->with('store')->with('product')->get();
            return $this->Success($transactions);
    }
    
    public function indexByType()
    {
       $transactions = Transaction::with('transaction_type')->with('user')->with('store')->with('product')->orderBy('transaction_type', 'asc')->get();
           return $this->Success($transactions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "store_id" => "required|exists:stores__outlets,id",
            "transaction_type_id" => "required|exists:transaction__types,id",
            "product_id" => "required|exists:products,id",
            "total_price" => "required|numeric|max:999999999|min:0",
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }

        $transactions = $request->user()->transactions()->create($validator->validated());

        return $this->Created($transactions);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transactions = Transaction::find($id);
        if(empty($transactions)){
            return $this->NotFound();
        }

        $transactions->products;

        return $this->Success($transactions);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transactions = Transaction::find($id);
        if(!$transactions){
            return $this->NotFound();
        }

        $transactions->delete();
        return $this->Success($transactions, "Deleted");
    }
}