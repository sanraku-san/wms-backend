<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stores_Outlets;
use App\Models\Transaction_Type;
use App\Models\Transaction;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory(10)->create();
        User::create([
            "username"=> "admin",
            "email"=> "admin@email.com",
            "password"=> "admin",
        ]);

        Profile::create([
            "first_name"=> "Admin Admin",
            "last_name"=> "Admin",
            "contact_number"=> "0123456789",
            "user_id"=> 1,
        ]);

        User::create([
            "username"=> "plsdiepie",
            "email"=> "pls@email.com",
            "password"=> "password",
        ]);

        Profile::create([
            "first_name"=> "Felix",
            "last_name"=> "PewDiePie",
            "contact_number"=> "0123456789",
            "user_id"=> 2,
        ]);

        Category::create([
            "name"=> "Food",
        ]);

        Category::create([
            "name"=> "Clothing",
        ]);

        Category::create([
            "name"=> "Electronics",
        ]);

        Category::create([
            "name"=> "Furniture",
        ]);

        Category::create([
            "name"=> "Toys",
        ]);
        
        Product::create([
            "name"=> "KKCRNCH 100",
            "description"=> "KOKO KRUNCH 100g",
            "price"=> 100.50,
            "barcode"=> "1010101010",
            "category_id"=> 1,
        ]);

        Product::create([
            "name"=> "Oreo Cookies",
            "description"=> "Oreo Chocolate Cookies 120g",
            "price"=> 50.00,
            "barcode"=> "1010101011",
            "category_id"=> 1,
        ]);

        Product::create([
            "name"=> "T-Shirt",
            "description"=> "Cotton T-Shirt",
            "price"=> 200.00,
            "barcode"=> "2020202020",
            "category_id"=> 2,
        ]);

        Product::create([
            "name"=> "Jeans",
            "description"=> "Denim Jeans",
            "price"=> 500.00,
            "barcode"=> "2020202021",
            "category_id"=> 2,
        ]);

        Product::create([
            "name"=> "Smartphone",
            "description"=> "Latest Android Smartphone",
            "price"=> 15000.00,
            "barcode"=> "3030303030",
            "category_id"=> 3,
        ]);

        Product::create([
            "name"=> "Laptop",
            "description"=> "High-performance Laptop",
            "price"=> 50000.00,
            "barcode"=> "3030303031",
            "category_id"=> 3,
        ]);

        Product::create([
            "name"=> "Sofa",
            "description"=> "Comfortable 3-seater Sofa",
            "price"=> 20000.00,
            "barcode"=> "4040404040",
            "category_id"=> 4,
        ]);

        Product::create([
            "name"=> "Dining Table",
            "description"=> "Wooden Dining Table",
            "price"=> 15000.00,
            "barcode"=> "4040404041",
            "category_id"=> 4,
        ]);

        Product::create([
            "name"=> "Action Figure",
            "description"=> "Superhero Action Figure",
            "price"=> 500.00,
            "barcode"=> "5050505050",
            "category_id"=> 5,
        ]);

        Product::create([
            "name"=> "Puzzle Game",
            "description"=> "1000-piece Puzzle Game",
            "price"=> 300.00,
            "barcode"=> "5050505051",
            "category_id"=> 5,
        ]);
        Stores_Outlets::create([
            "name"=> "SEVEN-EVILYN",
            "address"=> "Flood Way st. near the Ollado Family",
            "contact_number"=> "987654321",
            
        ]);
        Stores_Outlets::create([
            "name"=> "Soriano Sari-Sari Store",
            "address"=> "Countryside inside the Church",
            "contact_number"=> "123456789",       
        ]);

        Transaction_Type::create([
            "name"=> "Inbound",     
        ]);

        Transaction_Type::create([
            "name"=> "Outbound",     
        ]);
    }
}
