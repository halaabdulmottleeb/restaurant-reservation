<?php

namespace App\Http\Controllers;

use App\Http\Resources\TableResource;
use App\Services\TableService;

class TableController extends Controller
{
    public function __construct(
        protected TableService $tableService
    ){
    }

    public function getAll()
    {
        $meals = TableResource::collection($this->tableService->getAll());

        return response()->json([
            'status' => 'success',
            'data' => $meals,
        ], 200);
    }
}
