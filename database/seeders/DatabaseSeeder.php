<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Category::factory(25)->create();

        Product::factory(25)->create();

        $products = Product::all();
        $categories = Category::all();

        foreach ($products as $product) {

            for($i = 0; $i < rand(1,4); $i++ ){
                $product->categories()->attach($categories->random());
            }
        }
    }
}
