<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewCategoryResquest;
use App\Http\Requests\NewProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Client\Response;
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
        $product = (new Category())->fill($request->post());
        $product->save();
        return response()->json([
            'status' => 'ok'
        ]);
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
    public function update(Category $category, Request $request)
    {
        $category->fill($request->all())->save();

        return response()->json([
            'status' => 'ok',
            'product' => $category->toArray()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        $category->deleteOrFail();

        return \response()->json([
            'status' => 'ok'
        ]);
    }
}
