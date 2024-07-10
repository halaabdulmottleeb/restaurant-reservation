<?php

namespace App\Repositories;

use App\Models\OrderDetail;

class OrderDetailsRepository extends BaseRepository
{
    public function __construct(OrderDetail $model)
    {
        parent::__construct($model);
    }
}