<?php

namespace Database\Seeders;

use App\Models\StockTransaction;
use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\User;

class StockTransactionsSeeder extends Seeder
{
    public function run(): void
    {
        $product = Product::first();
        $user = User::first();

        if (!$product || !$user) return;

        StockTransaction::updateOrCreate([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'type' => 'IN',
            'quantity' => 20,
            'date' => now(),
            'status' => 'RECEIVED',
            'notes' => 'Initial stock'
        ]);

        StockTransaction::updateOrCreate([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'type' => 'OUT',
            'quantity' => 5,
            'date' => now(),
            'status' => 'ISSUED',
            'notes' => 'Sales'
        ]);
    }
}
