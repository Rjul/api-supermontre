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
    public function index()
    {
        return response()->json([
           ProductUser::ownedBy(User::find(3))->get()->toArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductUserRequest $request)
    {
        (new ProductUser())->fill($request->validated())->saveOrFail();
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
    public function show(ProductUser $productUser)
    {
        return response()->json([
            $productUser->toArray()
        ]);
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
    public function destroy(ProductUser $productUser)
    {
        $productUser->deleteOrFail();
        return response()->json([
            'status' => 'ok'
        ]);

    }
}
