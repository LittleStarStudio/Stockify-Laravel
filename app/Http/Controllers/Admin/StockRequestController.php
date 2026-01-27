<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockTransaction;

class StockRequestController extends Controller
{
    public function index()
    {
        $transactions = StockTransaction::where('status','PENDING')
            ->with(['product','user'])
            ->latest()
            ->get();

        return view('admin.stock-requests.index', compact('transactions'));
    }

    public function approve($id)
    {
        $tx = StockTransaction::findOrFail($id);
        $tx->status = $tx->type === 'IN' ? 'RECEIVED' : 'ISSUED';
        $tx->save();

        return back()->with('success','Stock request approved.');
    }

    public function reject($id)
    {
        $tx = StockTransaction::findOrFail($id);
        $tx->status = 'REJECTED';
        $tx->save();

        return back()->with('success','Stock request rejected.');
    }
}
