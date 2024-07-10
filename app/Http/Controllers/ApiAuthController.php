<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class ApiAuthController extends Controller
{
    public function __construct(
        protected UserService $userService
    ){
    }

    public function register(RegisterRequest $request)
    {
       $token = $this->userService->register($request->validated());

       if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to register user.',
            ], 500);
       }

       return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully.',
            'token' => $token,
        ], 200);
    }

    public function login(LoginRequest $request)
    {
        $token = $this->userService->login($request->validated());

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to log in. Invalid credentials.',
            ], 401);
       }

       return response()->json([
            'status' => 'success',
            'message' => 'Authenticated successfully',
            'token' => $token,
        ], 200);
    }
}
