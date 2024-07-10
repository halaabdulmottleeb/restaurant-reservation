<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected CustomerRepository $customerRepository
    ) {
    }

    public function register(array $data)
    {
        $user = $this->userRepository->create($data);

        if ($user) {
            $this->customerRepository->create(['user_id' => $user->id, 'phone' => $data['phone']]);
            $token = $user->createToken('Personal Access Token');

            return $token;
        }
       
        return null;
    }

    public function login(array $data)
    {
        $user = $this->userRepository->getOne('email', $data['email']);
       
        if ($user && Hash::check($data['password'], $user->password)) {
            return  $user->createToken('Token Name')->accessToken;
        }

        return null;
    }

    public function createStaffUser($data)
    {
        return $this->userRepository->create($data);
    }
}