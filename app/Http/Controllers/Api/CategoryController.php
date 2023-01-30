<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\NewCategoryResquest;
use App\Http\Requests\Category\UpdateCategoryResquest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Category::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(NewCategoryResquest $request)
    {
        if ($request->user() === null || $request->user()->cannot('create', new Category() )) {
            return response()->json([
                'status' => $request->user(),
                'message' => 'You can not create category'
            ], 401);
        }
        $product = (new Category())->fill($request->validated());
        $product->saveOrFail();
        return response()->json([
            'status' => 'ok'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        $category->load('products');
        return response()->json(
            $category->toArray()
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Category $category, UpdateCategoryResquest $request)
    {
        if ($request->user() === null || $request->user()->cannot('update', Category::class)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not update category'
            ], 401);
        }
        $category->forceFill($request->validated())->updateOrFail();

        return response()->json([
            'status' => 'ok',
            'category' => $category->load('products')->toArray()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Category $category)
    {
        if ($request->user() === null || $request->user()->cannot('delete', Category::class)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not destroy category'
            ], 401);
        }
        if (!$category->products->isEmpty()) {
            return \response()->json([
                'status' => 'fail',
                'message' => 'Category has products, can not delete'
            ], 409);
        }
        $category->deleteOrFail();

        return \response()->json([
            'status' => 'ok'
        ],204);
    }
}
