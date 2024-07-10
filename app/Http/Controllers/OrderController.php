<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ){
    }

    public function createOrder(CreateOrderRequest $request)
    {
        $data = $request->validated();
        $userId = auth()->user()->id;
        $order = $this->orderService->create($data, $userId);

        if(! $order)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully.',
        ], 200);
    }

    public function checkout(CheckoutRequest $request)
    {
        $data = $request->validated();
        $invoice = $this->orderService->checkout($data);

        return response()->json([
            'status' => 'success',
            'invoice' => $invoice,
            'message' => 'Order paid successfully.',
        ], 200);
    }
}
