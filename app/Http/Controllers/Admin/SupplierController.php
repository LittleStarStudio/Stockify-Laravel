<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;


class SupplierController extends Controller
{
    // Menampilkan semua data supplier (kecuali yang di delete)
    public function index(): View
    {
        $suppliers = Supplier::query()
            ->whereNull('deleted_at')
            ->latest()
            ->get();

        return view('admin.suppliers-management.index', [
            'suppliers' => $suppliers,
            'isTrash'   => false,
        ]);
    }

    // Create supplier
    public function store(StoreSupplierRequest $request): JsonResponse
    {
        $supplier = Supplier::create($request->validated());

        return response()->json([
            'message'  => 'Supplier created successfully',
            'supplier' => $supplier
        ]);
    }

    // Update supplier
    public function update(UpdateSupplierRequest $request, Supplier $supplier): JsonResponse
    {
        $supplier->update($request->validated());

        return response()->json([
            'message'  => 'Supplier updated successfully',
            'supplier' => $supplier
        ]);
    }

    // Menampilkan semua data supplier (hanya yang di soft delete)
    public function bin(): JsonResponse
    {
        $suppliers = Supplier::onlyTrashed()
            ->latest('deleted_at')
            ->get()
            ->map(function ($supplier) {
                return [
                    'id'         => $supplier->id,
                    'name'       => $supplier->name,
                    'email'      => $supplier->email ?? '-',
                    'phone'      => $supplier->phone ?? '-',
                    'address'    => $supplier->address ?? '-',
                    'deleted_at' => $supplier->deleted_at,
                ];
            });

        return response()->json($suppliers);
    }

    // Delete supplier (soft delete)
    public function destroy(Supplier $supplier): JsonResponse
    {
        $supplier->delete();

        return response()->json([
            'message'  => 'Supplier deleted successfully',
            'supplier' => [
                'id'      => $supplier->id,
                'name'    => $supplier->name,
                'email'   => $supplier->email,
                'phone'   => $supplier->phone,
                'address' => $supplier->address,
                'deleted_at' => now(),
            ]
        ]);

    }

    // Restore supplier (dari soft delete)
    public function restore(int $id): JsonResponse
    {
        $supplier = Supplier::onlyTrashed()->findOrFail($id);

        $supplier->restore();

        return response()->json([
            'message' => 'Supplier restored successfully',
            'supplier' => [
                'id'      => $supplier->id,
                'name'    => $supplier->name,
                'email'   => $supplier->email,
                'phone'   => $supplier->phone,
                'address' => $supplier->address,
            ]
        ]);
    }

    //Defensif layer
    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'bin']);
    }


}
