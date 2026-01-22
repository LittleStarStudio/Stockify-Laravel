<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function __construct()
    {
        // Hanya admin boleh CRUD
        $this->middleware('admin')->except(['index','bin']);
    }

    // VIEW LIST
    public function index(): View
    {
        $categories = Category::whereNull('deleted_at')->latest()->get();

        return view('admin.categories-management.index', compact('categories'));
    }

    // CREATE
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());

        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category
        ]);
    }

    // UPDATE
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());

        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category
        ]);
    }

    // BIN
    public function bin(): JsonResponse
    {
        return response()->json(
            Category::onlyTrashed()
                ->latest('deleted_at')
                ->get()
                ->map(fn($c)=>[
                    'id'=>$c->id,
                    'name'=>$c->name,
                    'description'=>$c->description ?? '-',
                    'deleted_at'=>$c->deleted_at,
                ])
        );
    }

    // DELETE (SOFT DELETE)
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json(['message'=>'Category deleted successfully']);
    }

    // RESTORE (DARI SOFT DELETE)
    public function restore(int $id): JsonResponse
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return response()->json(['message'=>'Category restored successfully']);
    }
}
