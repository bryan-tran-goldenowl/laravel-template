<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Mockery\Exception;

class AuthController extends Controller
{
    /**
     * Create User
     */
    public function createUser(RegisterRequest $request, UserRepository $userRepository)
    {
        $user = $userRepository->signup($request);
        return response()->json([
            'message' => 'User Created Successfully',
            'id' => $user->id
        ], 200);
    }


    /**
     * Login The User
     */
    public function loginUser(LoginRequest $request, UserRepository $userRepository)
    {
        try {
            if (!$user = $userRepository->login($request)) {
                return response()->json([
                    'message' => 'Can not login',
                ], 401);
            }

            return
                response()->json([
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
