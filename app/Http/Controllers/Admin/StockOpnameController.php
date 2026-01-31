<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\StockOpname;
use App\Models\StockOpnameItem;
use App\Models\Product;
use App\Models\StockTransaction;

use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    public function index(Request $request)
    {
        $query = StockOpname::with([
            'staff',
            'manager',
            'items.product.category'
        ]);

        // FILTER DATE
        if ($request->date) {
            $query->whereDate('date', $request->date);
        }

        // FILTER STATUS
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // FILTER MANAGER
        if ($request->manager) {
            $query->where('manager_id', $request->manager);
        }

        $opnames = $query->latest()->get();
        $products = Product::orderBy('name')->get();

        return view(
            'admin.stocks-opname.index',
            compact('opnames','products')
        );
    }

    public function show($id)
    {
        $opname = StockOpname::with('items.product')->findOrFail($id);
        return view('admin.stocks-opname.show', compact('opname'));
    }

    // SUBMIT (STAFF)
    public function submitFromClient(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.physical_stock' => 'required|integer|min:0'
        ]);

        $opname = StockOpname::create([
            'staff_id' => auth()->id(),
            'date' => now(),
            'status' => 'SUBMITTED'
        ]);

        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);

            $system = $product->current_stock;
            $diff = $item['physical_stock'] - $system;

            StockOpnameItem::create([
                'stock_opname_id' => $opname->id,
                'product_id' => $product->id,
                'system_stock' => $system,
                'physical_stock' => $item['physical_stock'],
                'difference' => $diff,
                'notes' => $item['notes'] ?? null,
            ]);
            
        }

        return response()->json(['success' => true]);
    }

    // EDIT
    public function edit($id)
    {
        $opname = StockOpname::with('items.product')->findOrFail($id);
        return view('admin.stocks-opname.edit', compact('opname'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $opname = StockOpname::findOrFail($id);

        $opname->items()->delete();

        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);

            $system = $product->current_stock;
            $diff = $item['physical_stock'] - $system;

            StockOpnameItem::create([
                'stock_opname_id' => $opname->id,
                'product_id' => $product->id,
                'system_stock' => $system,
                'physical_stock' => $item['physical_stock'],
                'difference' => $diff,
                'notes' => $item['notes'] ?? null,
            ]);
        }

        $opname->update([
            'status' => 'SUBMITTED'
        ]);

        return response()->json(['success'=>true]);
    }

    // DELETE
    public function destroy($id)
    {
        $opname = StockOpname::findOrFail($id);

        if ($opname->status === 'APPROVED') {
            abort(403);
        }

        $opname->items()->delete();
        $opname->delete();

        return response()->json(['success'=>true]);
    }

    // MANAGER / ADMIN
    public function approve(StockOpname $opname)
    {
        if ($opname->status !== 'SUBMITTED') abort(403);

        foreach ($opname->items as $item) {
            if ($item->difference == 0) continue;

            StockTransaction::create([
                'product_id'    => $item->product_id,
                'user_id'       => $opname->staff_id,
                'approved_by'   => auth()->id(),
                'type'          => $item->difference > 0 ? 'IN' : 'OUT',
                'quantity'      => abs($item->difference),
                'system_stock'  => $item->system_stock,
                'physical_stock'=> $item->physical_stock,
                'status'        => $item->difference > 0 ? 'RECEIVED' : 'ISSUED',
                'source'        => 'OPNAME',
                'date'          => now(),
                'notes'         => 'Stock adjustment from stock opname'
            ]);
        }

        $opname->update([
            'status' => 'APPROVED',
            'manager_id' => auth()->id()
        ]);

        return back();
    }

    // REJECT
    public function reject(StockOpname $opname)
    {
        if ($opname->status !== 'SUBMITTED') abort(403);

        $opname->update([
            'status' => 'REJECTED',
            'manager_id' => auth()->id()
        ]);

        return back();
    }

    // CHANGE STATUS (UNIVERSAL)
    public function changeStatus(Request $request, StockOpname $opname)
    {
        $request->validate([
            'status' => 'required|in:APPROVED,REJECTED'
        ]);

        
        if (!in_array($opname->status, ['SUBMITTED','APPROVED','REJECTED'])) {
            abort(403);
        }

        $opname->update([
            'status' => $request->status,
            'manager_id' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'status' => $request->status
        ]);
    }

}

