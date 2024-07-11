<?php

namespace App\Services;

use App\Models\Meal;
use App\Repositories\MealRepository;
use App\Repositories\MealStockRepository;
use App\Repositories\OrderDetailsRepository;
use App\Repositories\OrderRepository;
use App\Services\Checkout\CheckoutService;

class OrderService
{
    public function __construct(
        protected OrderRepository $orderRepository,
        protected MealRepository $mealRepository,
        protected OrderDetailsRepository $orderDetailsRepository,
        protected MealStockRepository $mealStockRepository
    ) {
    }

    public function create($data, $userId)
    {
        $mealIds = collect($data['meals'])->pluck('meal_id');
        $meals = $this->mealRepository->getMeals($mealIds);
        $totalPrice = 0;
        
        foreach($meals as $meal) {

            if (!$meal->available_quantity) {
                return false;
            }

            $totalPrice += $meal->price_after_discount;
        }
    
        $order = [
            'table_id' => $data['table_id'],
            'reservation_id' => $data['reservation_id'],
            'customer_id' => $data['customer_id'],
            'user_id' => $userId,
            'total' => $totalPrice,
            'paid' => $data['paid'],
            'date' => $data['date'],
        ];
        $order = $this->orderRepository->create($order);

        foreach ($data['meals'] as $mealData) {
            $orderDetail = [
                'meal_id' => $mealData['meal_id'],
                'order_id' => $order->id,
                'amount_to_pay' => Meal::find($mealData['meal_id'])->price_after_discount,
            ];
            $this->mealStockRepository->updateStock($mealData['meal_id']);
            $this->orderDetailsRepository->create($orderDetail);
        }

        return $order;
    }

    public function checkout($data)
    {
        $orderId = $data['order_id'];
        $checkoutService = new CheckoutService($data['checkout_type']);
        $order = $this->orderRepository->find($orderId);
        $invoice = $checkoutService->invoice($order->total);
        $invoice['order_id'] = $orderId;
        $this->orderRepository->update($orderId, ['paid' => true]);

        return  $invoice;
    }
}