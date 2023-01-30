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
    public function index(Request $request)
    {
        if ($request->user() === null || $request->user()->cannot('viewAny', new User() )) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not view any user'
            ], 401);
        }
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
        if ($request->user() === null || $request->user()->cannot('create', new User() )) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not create user'
            ], 401);
        }
        (new User)->fill($request->validated())->saveOrFail();
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
    public function show(Request $request, User $user)
    {
        if ($request->user() === null || $request->user()->cannot('view', $user )) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not view this user'
            ], 401);
        }
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
        if ($request->user() === null || $request->user()->cannot('update', $user )) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not update this user'
            ], 401);
        }
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
    public function destroy(Request $request, User $user)
    {
        if ($request->user() === null || $request->user()->cannot('delete', $user )) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You can not delete this user'
            ], 401);
        }
        $user->deleteOrFail();
        return response()->json([
            'status' => 'ok'
        ], 204);
    }
}
