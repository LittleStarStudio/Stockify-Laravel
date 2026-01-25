<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ProductAttribute;

class ProductAttributeController extends Controller
{
    public function index() {
        
        $attributes = ProductAttribute::whereNull('deleted_at')
        ->latest()
        ->get();

        return view('admin.product-attributes.index', compact('attributes'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:product_attributes,name'
        ]);

        $baseSlug = Str::slug($request->name);
        $count = ProductAttribute::where('slug', 'like', $baseSlug . '%')->count();
        $slug = $count ? $baseSlug . '-' . ($count + 1) : $baseSlug;

        ProductAttribute::create([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return response()->json(['message' => 'Attribute created']);
    }

    public function update(Request $request, ProductAttribute $attribute) {
        $request->validate([
            'name' => 'required|unique:product_attributes,name,' . $attribute->id
        ]);

        $baseSlug = Str::slug($request->name);
        $count = ProductAttribute::where('slug', 'like', $baseSlug . '%')->where('id', '!=', $attribute->id)->count();
        $slug = $count ? $baseSlug . '-' . ($count + 1) : $baseSlug;

        $attribute->update([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return response()->json(['message' => 'Attribute updated']);
    }

    public function destroy(ProductAttribute $attribute) {
        $attribute->delete();
        return response()->json(['message' => 'Attribute deleted']);
    }

    public function bin() {
        $attributes = ProductAttribute::onlyTrashed()->latest()->get();
        return response()->json($attributes);
    }

    public function restore($id) {
        ProductAttribute::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['message' => 'Attribute restored']);
    }

}
