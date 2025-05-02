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
        if(!request()->user()->can('index transaction_types')){
            return $this->Forbidden();
        }
        $transactionType = Transaction_Type::all();
        
        return $this->Success($transactionType);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!request()->user()->can('view transaction_type')){
            return $this->Forbidden();
        }
        
        $transactionType = Transaction_Type::find($id);
        if(empty($transactionType)){
            return $this->NotFound();
        }
        return $this->Success($transactionType);
    }
}
