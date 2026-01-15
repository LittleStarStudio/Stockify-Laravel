<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;


class SupplierController extends Controller
{
    // Menampilkan semua data supplier (kecuali yang di delete)
    public function index(): View
    {
        $suppliers = Supplier::query()
            ->latest()
            ->get();

        return view('admin.suppliers-management.index', [
            'suppliers' => $suppliers,
            'isTrash'   => false,
        ]);
    }

    // Create supplier
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['nullable', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $supplier = Supplier::create($validator->validated());

        return response()->json([
            'message'  => 'Supplier created successfully',
            'supplier' => $supplier
        ]);
    }

    // Update supplier
    public function update(Request $request, Supplier $supplier): JsonResponse
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['nullable', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
        ]);

        $supplier->update($validated);

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


}
