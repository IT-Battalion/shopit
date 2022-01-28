<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = ProductCategory::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $data = $request->validated();
        $coupon = ProductCategory::create($data);
        $coupon = ProductCategory::find($coupon->id);
        return response()->json($coupon);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param ProductCategory $category
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, ProductCategory $category): JsonResponse
    {
        $data = $request->validated();
        $category->update($data);
        return response()->json($category->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProductCategory $category
     * @return void
     */
    public function destroy(ProductCategory $category): void
    {
        $category->delete();
    }
}
