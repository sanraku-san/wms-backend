<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;

class Stores_Outlets extends Model
{
    protected $fillable = [
        'name', 'address', 'contact_number'
    ];

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
