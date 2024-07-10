<?php

namespace App\Repositories;

use App\Models\Meal;
use App\Models\MealStock;
use Carbon\Carbon;

class MealStockRepository extends BaseRepository
{
    public function __construct(MealStock $model)
    {
        parent::__construct($model);
    }

    public function updateStock($mealId)
    {
        $today = Carbon::today()->toDateString();

        $mealStock = $this->model::firstOrCreate(
            ['meal_id' => $mealId, 'date' => $today],
            ['available_quantity' => Meal::find($mealId)->available_quantity]
        );
    
        $mealStock->decrement('available_quantity', 1);
        $mealStock->save();
    }
}