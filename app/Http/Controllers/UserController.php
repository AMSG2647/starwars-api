<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public $user;

    /*
    Llamo al objeto en el contructor para no invocarlo
    todo el tiempo en las funciones
    */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get  (
     *     path="/users",
     *     tags={"Users"},
     *     summary="Query all users",
     *     operationId="index",
     *     security={{"bearerAuth":{}}},
     *   @OA\Response(response="200", description="returns the registered users"),
     *   @OA\Response(response="422", description="validation error"),
     *   @OA\Response(response="500", description="internal error"),
     * )
     * */

    public function index(): JsonResponse
    {
        try {
            $user = $this->user->all();
            return response()->json(
                [
                    'data' => $user,
                    'message' => 'Query Completed Successfully'
                ]);
        } catch (\Exception $e) {
            Log::debug('index user fail:' . $e->getMessage());
            return response()->json(
                [
                    'data' => null,
                    'message' => $e->getMessage()
                ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * @OA\Post (
     *     path="/users",
     *     tags={"Users"},
     *     summary="register users",
     *     operationId="store",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *     @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     oneOf={
     *                     	   @OA\Schema(type="string"),
     *                     	   @OA\Schema(type="integer"),
     *                     }
     *                 ),
     *                 example={"name": "Angel", "email": "angelmserranog@gmail.com", "password": 12345678}
     *             )
     *         ),
     *   @OA\Schema(ref="#/components/schemas/UserStoreRequest")
     *   ),
     *   @OA\Response(response="200", description="returns the registered object"),
     *   @OA\Response(response="422", description="validation error"),
     *   @OA\Response(response="500", description="internal error"),
     * )
     * */

    public function store(UserStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->user->store();
            $token = JWTAuth::fromUser($user);
            DB::commit();
            return response()->json(
                [
                    'token' => $token,
                    'data' => $user,
                    'message' => 'Registration Completed Successfully'
                ]
            );
        } catch (\Exception $e) {
            Log::debug('user register fail:' . $e->getMessage());
            DB::rollBack();
            return response()->json(
                [
                    'data' => null,
                    'message' => $e->getMessage()
                ], 500);
        }
    }

    /**
     * Display the specified resource.
     */

    /**
     * @OA\Get (
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Return a query",
     *     operationId="show",
     *     security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *  ),
     *   @OA\Response(response="200", description="returns a registered query"),
     *   @OA\Response(response="422", description="validation error"),
     *   @OA\Response(response="500", description="internal error"),
     * )
     * */

    public function show(string $id)
    {
        try {
            $user = $this->user->getById($id);
            return response()->json(
                [
                    'data' => $user,
                    'message' => 'Successful Found User'
                ]);
        } catch (\Exception $e) {
            Log::debug('show users fail:' . $e->getMessage());
            return response()->json(
                [
                    'data' => null,
                    'message' => $e->getMessage()
                ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * @OA\Put (
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Update a data",
     *     operationId="update",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *   ),
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     oneOf={
     *                     	   @OA\Schema(type="string"),
     *                     	   @OA\Schema(type="integer"),
     *                     }
     *                 ),
     *                 example={"name": "Angel", "email": "angelmserranog@gmail.com", "password": 12345678}
     *             )
     *         ),
     *   @OA\Schema(ref="#/components/schemas/UserUpdateRequest")
     *   ),
     *   @OA\Response(response="200", description="returns a updated query"),
     *   @OA\Response(response="422", description="validation error"),
     *   @OA\Response(response="500", description="internal error"),
     * )
     * */

    public function update(UserUpdateRequest $request, string $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = $this->user->getById($id);
            $user->update(request(['email', 'name']));
            DB::commit();
            return response()->json(
                [
                    'data' => $user,
                    'message' => 'Updated Completed Successfully'
                ]);
        } catch (\Exception $e) {
            Log::debug('update users fail:' . $e->getMessage());
            DB::rollBack();
            return response()->json(
                [
                    'data' => null,
                    'message' => $e->getMessage()
                ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete  (
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Delete to data",
     *     operationId="destroy",
     *     security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *  ),
     *   @OA\Response(response="200", description="returns a delete query"),
     *   @OA\Response(response="422", description="validation error"),
     *   @OA\Response(response="500", description="internal error"),
     * )
     * */

    public function destroy(string $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = $this->user->getById($id);
            $user->delete();
            DB::commit();
            return response()->json(
                [
                    'data' => $user,
                    'message' => 'Destroy Completed Successfully'
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug('destroy user fail:' . $e->getMessage());
            return response()->json(
                [
                    'data' => null,
                    'message' => $e->getMessage()
                ], 500);
        }
    }
}
