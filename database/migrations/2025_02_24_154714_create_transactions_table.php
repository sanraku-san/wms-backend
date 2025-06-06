<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("store_id");
            $table->unsignedBigInteger("transaction_type_id");
            $table->unsignedBigInteger("product_id");
            $table->decimal("total_price", 16, 2);
            $table->softDeletes();
            $table->timestamps();

            
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("store_id")->references("id")->on("stores__outlets")->onDelete("cascade");
            $table->foreign("transaction_type_id")->references("id")->on("transaction__types")->onDelete("cascade");
            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
