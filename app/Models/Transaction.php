<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Stores_Outlets;
use App\Models\Transaction_Type;
use App\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id','store_id','transaction_type_id','product_id','total_price'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function store(){
        return $this->belongsTo(Stores_Outlets::class);
    }
    public function transaction_type(){
        return $this->belongsTo(Transaction_Type::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}