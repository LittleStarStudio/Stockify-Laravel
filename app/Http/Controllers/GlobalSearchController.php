<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;

class GlobalSearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        if (!$q) {
            return back();
        }

        $products = Product::where('name','like',"%$q%")->limit(5)->get();
        $suppliers = Supplier::where('name','like',"%$q%")->limit(5)->get();
        $users = User::where('name','like',"%$q%")->limit(5)->get();

        return view('search.index', compact(
            'q','products','suppliers','users'
        ));
    }
}

