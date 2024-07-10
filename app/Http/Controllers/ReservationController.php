<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckAvailabilityRequest;
use App\Http\Requests\ReserveTableRequest;
use App\Http\Resources\TableResource;
use App\Services\ReservationService;

class ReservationController extends Controller
{
    public function __construct(
        protected ReservationService $reservationService
    ){
    }

    public function reserve(ReserveTableRequest $request)
    {
        $customer = auth()->user() ? auth()->user()->customer : null;
        
        if (!$customer) {
            return response()->json([
                'status' => 'error',
                'message' => 'You must be logged in as a customer to reserve a table.',
            ], 401);
        }

        $data = $request->validated();
        $checkReserve = $this->reservationService->reserve($data, $customer);

        if (!$checkReserve) {
            return response()->json([
                'status' => 'error',
                'message' => 'The table you are trying to reserve is not available at the requested time.',
            ], 409);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Table reserved successfully.',
        ], 200);

    }

    public function checkAvailability(CheckAvailabilityRequest $request)
    {
        $data = $request->validated();
        $checkAvailablity = TableResource::collection($this->reservationService->checkAvailability($data));

        return response()->json([
            'status' => 'success',
            'is_avaialble' => $checkAvailablity,
        ], 200);
    }
}
