<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealResource;
use App\Services\MealService;

class MealController extends Controller
{
    public function __construct(
        protected MealService $mealService
    ){
    }

    public function getAll()
    {
        $meals = MealResource::collection($this->mealService->getAll());

        return response()->json([
            'status' => 'success',
            'data' => $meals,
        ], 200);
    }
}