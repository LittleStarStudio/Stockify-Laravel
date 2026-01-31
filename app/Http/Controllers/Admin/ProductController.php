<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\ProductAttribute;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,manajer_gudang')
            ->except(['index','bin']);
    }

    public function index(): View
    {
        $products = Product::with(['category','supplier','attributeValues.attribute'])
            ->whereNull('deleted_at')
            ->latest()
            ->get();

        $categories = Category::orderBy('name')->get();
        $suppliers  = Supplier::orderBy('name')->get();
        $attributes = ProductAttribute::orderBy('name')->get();

        return view(
            'admin.products-management.index',
            compact('products','categories','suppliers','attributes')
        );

    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('products', 'public');
        }

        $product = Product::create($data);

        if ($request->filled('attributes')) {

            $clean = collect($request->input('attributes'))
                ->unique('id')
                ->filter(fn($r) => !empty($r['id']) && !empty($r['value']));

            foreach ($clean as $row) {
                $product->attributeValues()->create([
                    'attribute_id' => $row['id'],
                    'value' => $row['value'],
                ]);
            }
        }

        return response()->json(['message'=>'Product created']);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('products', 'public');
        }

        DB::transaction(function () use ($product, $data, $request) {

            $product->update($data);
            $product->attributeValues()->delete();

        });

        if ($request->filled('attributes')) {

            $clean = collect($request->input('attributes'))
                ->unique('id')
                ->filter(fn($r) => !empty($r['id']) && !empty($r['value']));

            foreach ($clean as $row) {
                $product->attributeValues()->create([
                    'attribute_id' => $row['id'],
                    'value' => $row['value'],
                ]);
            }
        }

        return response()->json(['message'=>'Product updated']);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message'=>'Product deleted']);
    }

    public function bin()
    {
        return response()->json(
            Product::onlyTrashed()
                ->with(['category','supplier'])
                ->latest('deleted_at')
                ->get()
        );
    }

    public function restore(int $id)
    {
        Product::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['message'=>'Product restored']);
    }
}

