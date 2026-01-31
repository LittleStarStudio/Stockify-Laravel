<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

use App\Models\Category;
use App\Models\Supplier;

class ProductsSeeder extends Seeder
{
    
    public function run(): void
    {
        $category = Category::first();
        $supplier = Supplier::first();

        if (!$category || !$supplier) return;

        for ($i = 1; $i <= 25; $i++) {
            Product::updateOrCreate([
                'category_id' => $category->id,
                'supplier_id' => $supplier->id,
                'name' => "Product {$i}",
                'sku' => "SKU-000{$i}",
                'description' => "Demo product {$i}",
                'purchase_price' => 10000,
                'selling_price' => 15000,
                'minimum_stock' => 5,
            ]);
        }
    }

}
