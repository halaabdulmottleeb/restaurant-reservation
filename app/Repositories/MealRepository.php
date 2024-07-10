<?php

namespace App\Repositories;

use App\Models\Meal;

class MealRepository extends BaseRepository
{
    public function __construct(Meal $model)
    {
        parent::__construct($model);
    }

    public function getMeals($mealIds)
    {
        return $this->model::whereIn('id', $mealIds)->get();
    }
}