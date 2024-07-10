<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }
}