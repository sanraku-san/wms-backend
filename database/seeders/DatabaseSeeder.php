<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Profile;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction_Type;
use App\Models\Stores_Outlets;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Exception;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
            "image"=> "images/users/admin.jpg",
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
        
        User::create([
            "username"=> "viewer",
            "email"=> "viewer@email.com",
            "password"=> "viewer",
        ]);

        Profile::create([
            "first_name"=> "Viewer Viewer",
            "last_name"=> "Viewer",
            "contact_number"=> "0123456789",
            "user_id"=> 3,
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
            "stock"=> 100,
            "image"=> "images/products/koko.png",
        ]);

        Product::create([
            "name"=> "Oreo Cookies",
            "description"=> "Oreo Chocolate Cookies 120g",
            "price"=> 50.00,
            "barcode"=> "1010101011",
            "stock"=> 100,
            "image"=> "images/products/oreo.png",
            "category_id"=> 1,
        ]);

        Product::create([
            "name"=> "T-Shirt",
            "description"=> "Cotton T-Shirt",
            "price"=> 200.00,
            "barcode"=> "2020202020",
            "category_id"=> 2,
            "stock"=> 100,
            "image"=> "images/products/shirt.png",
        ]);

        Product::create([
            "name"=> "Jeans",
            "description"=> "Denim Jeans",
            "price"=> 500.00,
            "barcode"=> "2020202021",
            "category_id"=> 2,
            "stock"=> 100,
            "image"=> "images/products/jeans.png",
        ]);

        Product::create([
            "name"=> "Smartphone",
            "description"=> "Latest Android Smartphone",
            "price"=> 15000.00,
            "barcode"=> "3030303030",
            "category_id"=> 3,
            "stock"=> 100,
            "image"=> "images/products/phone.png",
        ]);

        Product::create([
            "name"=> "Laptop",
            "description"=> "High-performance Laptop",
            "price"=> 50000.00,
            "barcode"=> "3030303031",
            "category_id"=> 3,
            "stock"=> 100,
            "image"=> "images/products/laptop.png",
        ]);

        Product::create([
            "name"=> "Sofa",
            "description"=> "Comfortable 3-seater Sofa",
            "price"=> 20000.00,
            "barcode"=> "4040404040",
            "category_id"=> 4,
            "stock"=> 100,
            "image"=> "images/products/sofa.png",
        ]);

        Product::create([
            "name"=> "Dining Table",
            "description"=> "Wooden Dining Table",
            "price"=> 15000.00,
            "barcode"=> "4040404041",
            "category_id"=> 4,
            "stock"=> 100,
            "image"=> "images/products/table.png",
        ]);

        Product::create([
            "name"=> "Action Figure",
            "description"=> "Superhero Action Figure",
            "price"=> 500.00,
            "barcode"=> "5050505050",
            "category_id"=> 5,
            "stock"=> 100,
            "image"=> "images/products/action.png",
        ]);

        Product::create([
            "name"=> "Puzzle Game",
            "description"=> "1000-piece Puzzle Game",
            "price"=> 300.00,
            "barcode"=> "5050505051",
            "category_id"=> 5,
            "stock"=> 100,
            "image"=> "images/products/puzzle.png",
        ]);
        Product::create([
            "name"=> "Alden Photocard",
            "description"=> "Alden Richards Tongue Out Picture",
            "price"=> 5000000.00,
            "barcode"=> "9999999999",
            "category_id"=> 1,
            "stock"=> 1,
            "image"=> "images/products/admin.jpg",
        ]);

        Stores_Outlets::create([
            "name"=> "Store 1",
            "address"=> "123 Main St, City, Country",
            "contact_number"=> "0123456789",
        ]);

        Stores_Outlets::create([
            "name"=> "Store 2",
            "address"=> "456 Elm St, City, Country",
            "contact_number"=> "9876543210",
        ]);

        Transaction_Type::create([
            "name"=> "Inbound",
        ]);

        Transaction_Type::create([
            "name"=> "Outbound",
        ]);

        $permissions = [
            'create user',
            'index users',
            'view user',
            'update user',
            'delete user',
            'create store',
            'index stores',
            'view store',
            'update store',
            'delete store',
            'create category',
            'index categories',
            'view category',
            'update category',
            'delete category',
            'index transaction_types',
            'view transaction_type',
            'create product',
            'index products',
            'view product',
            'update product',
            'delete product',
            'create transaction',
            'index transactions',
            'view transaction',
            'update transaction',
            'delete transaction',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $moderator = Role::create(['name' => 'moderator']);
        $moderator->givePermissionTo(Permission::all()->filter(function ($permission) {
            return !in_array($permission->name, ['create user', 'delete user', 'update user']);
        }));

        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo(Permission::all()->filter(function ($permission) {
            return !in_array($permission->name, ['create user', 'index users', 'delete user', 'create store', 'delete store', 'update store', 'create category', 'delete category', 'update category', 'create product', 'delete product', 'update product']);
        }));
        
        $viewer = Role::create(['name' => 'viewer']);

        $viewer->givePermissionTo(Permission::where(function ($query) {
            $query->where('name', 'not like', '%user%')
                  ->where('name', 'not like', '%user');
        })->where(function ($query) {
            $query->where('name', 'like', 'view%')
                  ->orWhere('name', 'like', 'index%');
        })->get());

        $adminUser = User::where('username', 'admin')->first();
        $adminUser->assignRole('admin');

        $moderatorUser = User::where('username', 'plsdiepie')->first();
        $moderatorUser->assignRole('moderator');

        $viewerUser = User::where('username', 'viewer')->first();
        $viewerUser->assignRole('viewer');

    }
}
