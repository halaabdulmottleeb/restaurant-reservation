<?php

namespace App\Services;

use App\Repositories\MealRepository;
use Illuminate\Support\Facades\Hash;

class MealService
{
    public function __construct(
        protected MealRepository $mealRepository,
    ) {
    }

    public function getAll()
    {
        return $this->mealRepository->all();
    }
}