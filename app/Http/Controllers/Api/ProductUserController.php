<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductUser\ProductUserRequest;
use App\Http\Requests\User\CreateUserResquest;
use App\Http\Requests\User\UpdateUserResquest;
use App\Models\ProductUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProductUserController extends Controller
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
                'message' => 'You can not view any product user'
            ], 401);
        }
        if ($request->user()->isAdmin()) {
            return response()->json(
                ProductUser::with('product')->get()->toArray()
            );
        }
        return response()->json(
           ProductUser::ownedBy($request->user()->id)->with('product')->get()->toArray()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductUserRequest $request)
    {
        if ($request->user() === null) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not create product user, please login'
            ], 401);
        }
        if ($request->user()->id !== (int) $request->get('user_id')) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not create for other user'
            ], 401);
        }
        if ((new ProductUser())->fill($request->validated())->saveOrFail()) {
            return response()->json([
                'status' => 'ok'
            ], 201);
        }
        return response()->json([
            'status' => 'fail',
            'message' => 'Can not create product user'
        ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, ProductUser $productUser)
    {
        if ($request->user() === null) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not view this product user, please login'
            ], 401);
        }
        if ($productUser->user_id !== $request->user()->id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not view this product user'
            ], 401);
        }
        return response()->json(
            $productUser->toArray()
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProductUserRequest $request, ProductUser $productUser)
    {
        if ($request->user() === null) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not update this product user, please login'
            ], 401);
        }
        if ($request->user()->id !== $productUser->user_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not update this product user'
            ], 401);
        }
        $productUser->forceFill($request->validated())->updateOrFail();
        return response()->json([
            'status' => 'ok'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, ProductUser $productUser)
    {
        if ($request->user() === null) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not delete this product user, please login'
            ], 401);
        }
        if ($request->user()->id !== $productUser->user_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not delete this product user'
            ], 401);
        }
        $productUser->deleteOrFail();
        return response()->json([
            'status' => 'ok'
        ], 204);

    }
}
