<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;

class StockInputController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active',1)->orderBy('name')->get();

        return view('admin.stock-inputs.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:IN,OUT',
            'quantity'   => 'required|integer|min:1',
            'notes'      => 'nullable|string|max:255'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->type == 'OUT' && $request->quantity > $product->current_stock) {
            return response()->json([
                'message' => 'Insufficient stock'
            ], 422);
        }

        StockTransaction::create([
            'product_id' => $request->product_id,
            'user_id'    => auth()->id(),
            'type'       => $request->type,
            'quantity'   => $request->quantity,
            'date'       => now(),
            'status'     => 'PENDING',
            'notes'      => $request->notes
        ]);

        return response()->json([
            'message' => 'Stock request has been sent'
        ]);
    }
}
