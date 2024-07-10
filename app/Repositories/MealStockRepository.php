<?php

namespace App\Repositories;

use App\Models\MealStock;

class MealStockRepository extends BaseRepository
{
    public function __construct(MealStock $model)
    {
        parent::__construct($model);
    }
}