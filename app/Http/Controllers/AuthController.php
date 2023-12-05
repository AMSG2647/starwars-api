<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * @OA\Post (
     *     path="/login",
     *     tags={"Auth"},
     *     summary="login users",
     *     operationId="login",
     *
     *     @OA\RequestBody(
     *     @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
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
     *                 example={"email": "admin@starwars.com", "password": 12345678}
     *             )
     *         ),
     *   @OA\Schema(ref="#/components/schemas/LoginRequest")
     *   ),
     *   @OA\Response(response="200", description="returns the registered object"),
     *   @OA\Response(response="422", description="validation error"),
     *   @OA\Response(response="500", description="internal error"),
     * )
     * */

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(
                    [
                        'data' => null,
                        'message' => 'invalid credentials'
                    ], 400);
            }

        } catch (JWTException $e) {
            Log::debug('login fail:' . $e->getMessage());
            return response()->json(
                [
                    'data' => null,
                    'message' => $e->getMessage()
                ], 500);
        }

        return response()->json(compact('token'));
    }
}
