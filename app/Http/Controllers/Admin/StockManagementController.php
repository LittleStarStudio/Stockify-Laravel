<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockTransaction;

class StockManagementController extends Controller
{
    public function index()
    {
        $transactions = StockTransaction::with(['product','user'])
            ->latest()
            ->get();

        return view('admin.stocks-management.index', compact('transactions'));
    }
}
