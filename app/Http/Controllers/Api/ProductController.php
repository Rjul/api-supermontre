<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\NewProductRequest;
use App\Http\Requests\Product\UpdateProductResquest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Product::with('category')->get()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(NewProductRequest $request)
    {
        $imageName = time().'_'.$request->image->getClientOriginalName();
        $imageUrl = '/storage/'.$request->file('image')->storeAs('uploads', $imageName, 'public');

        $product = (new Product())->fill($request->validated());
        $product->imageUrl = $imageUrl;
        $product->saveOrFail();
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
    public function show(Product $product)
    {
        $product->load('category');
        return response()->json(
            $product->toArray()
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Product $product, UpdateProductResquest $request)
    {
        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $imageUrl = '/storage/'.$request->file('image')->storeAs('uploads', $imageName, 'public');
            $product->imageUrl = $imageUrl;
        }
        $product->forceFill($request->validated())->updateOrFail();

        return response()->json([
            'status' => 'ok',
            'product' => $product->load('category')->toArray()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        $product->deleteOrFail();

        return \response()->json([
            'status' => 'ok'
        ]);
    }
}
