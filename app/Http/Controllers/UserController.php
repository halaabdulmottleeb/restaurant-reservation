<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStaffUserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ){
    }

    public function createStaffUser(CreateStaffUserRequest $request) 
    {
        $data = $request->validated();
        $user = $this->userService->createStaffUser($data);

        if(!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Staff user Created successfully.',
        ], 200);
    }
}
