<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserResquest;
use App\Http\Requests\User\UpdateUserResquest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(
           User::all()->toArray()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserResquest $request)
    {
        (new User)->fill($request->validated())->saveOrFail();
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
    public function show(User $user)
    {
        return response()->json([
            $user->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserResquest $request, User $user)
    {
        $user->forceFill($request->validated());
        if ($request->has('password')) {
            $user->password = Hash::make($request->get('password'));
        }
        $user->updateOrFail();
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
    public function destroy(User $user)
    {
        $user->deleteOrFail();
        return response()->json([
            'status' => 'ok'
        ]);
    }
}
