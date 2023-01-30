<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductUser;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->user() === null) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not view any order'
            ], 401);
        }
        return response()->json(
            Order::OwnedBy($request->user())->get()->toArray()
        );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->user() === null) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not create order'
            ], 401);
        }
        if ($request->user()->createOrder()) {
            return response()->json([
                'status' => 'ok',
                'order' => $request->user()->orders()->latest()->first()->toArray(),
            ], 201);
        }
        return response()->json([
            'status' => 'fail',
            'message' => 'You can not create order'
        ], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Order $order)
    {
        if ($request->user() === null) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not view any order'
            ], 401);
        }
        if ($request->user()->id !== $order->user_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not view this order'
            ], 401);
        }
        return response()->json([
            'status' => 'ok',
            'order' => $order->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
