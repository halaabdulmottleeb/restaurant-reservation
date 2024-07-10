<?php

namespace App\Services;

use App\Repositories\TableRepository;

class TableService
{
    public function __construct(
        protected TableRepository $tableRepository,
    ) {
    }

    public function getAll()
    {
        return $this->tableRepository->all();
    }

}