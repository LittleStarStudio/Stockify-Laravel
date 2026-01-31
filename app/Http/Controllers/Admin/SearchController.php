<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        if (!$q) {
            return back();
        }

        $products = Product::where('name', 'like', "%$q%")->get();
        $suppliers = Supplier::where('name', 'like', "%$q%")->get();
        $users = User::where('name', 'like', "%$q%")->get();

        return view('admin.search.index', compact(
            'q', 'products', 'suppliers', 'users'
        ));
    }
}
