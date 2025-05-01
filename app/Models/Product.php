<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Transaction;

class Product extends Model
{
    protected $fillable = [
        "name", "description", "price", "barcode", "category_id"
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }

    
    // public function transactions(){
    //     return $this->belongsToMany(Transaction::class)->withPivot("quantity", "price");
    // }
}

