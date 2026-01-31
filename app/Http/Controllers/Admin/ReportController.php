<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\ProductsExport;
use App\Exports\StockTransactionsExport;
use App\Exports\StockOpnamesExport;
use App\Exports\UsersExport;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\StockOpname;
use App\Models\User;

class ReportController extends Controller
{
    // PAGES
    public function products()
    {
        return view('admin.reports.products');
    }

    public function transactionsPage()
    {
        return view('admin.reports.transactions');
    }

    public function opnames()
    {
        return view('admin.reports.opnames');
    }

    // EXPORT TRANSACTIONS
    public function transactionsExport(Request $r)
    {
        $from = $r->from;
        $to   = $r->to;
        $type = $r->type;

        $query = StockTransaction::whereBetween('date', [$from, $to]);

        if ($type) {
            $query->where('type', $type);
        }

        if ($query->count() == 0) {
            return back()->with('error','No data found for selected period');
        }

        $now = now()->format('Ymd_His');

        return Excel::download(
            new StockTransactionsExport($from, $to, $type),
            "report-transactions-{$from}_to_{$to}_{$now}.xlsx"
        );
    }

    // EXPORT PRODUCTS
    public function productsExport()
    {
        if (Product::count() == 0) {
            return back()->with('error','No product data found');
        }

        $now = now()->format('Ymd_His');

        return Excel::download(
            new ProductsExport,
            "report-products-{$now}.xlsx"
        );
    }

    // EXPORT OPNAMES
    public function opnamesExport()
    {
        if (StockOpname::count() == 0) {
            return back()->with('error','No opname data found');
        }

        $now = now()->format('Ymd_His');

        return Excel::download(
            new StockOpnamesExport,
            "report-opnames-{$now}.xlsx"
        );
    }

    // USERS PAGE
    public function users()
    {
        return view('admin.reports.users');
    }

    // USERS EXPORT
    public function usersExport()
    {
        if (User::count() == 0) {
            return back()->with('error','No user data found');
        }

        $now = now()->format('Ymd_His');

        return Excel::download(
            new UsersExport,
            "report-users-{$now}.xlsx"
        );
    }

}
