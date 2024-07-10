<?php

namespace App\Http\Requests;

use App\Enums\UserRoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('api')->check() && Auth::guard('api')->user()->role === UserRoleEnum::WAITER;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'table_id' => 'required|exists:tables,id',
            'reservation_id' => 'required|exists:reservations,id',
            'customer_id' => 'required|exists:customers,id',
            'paid' => 'required|boolean',
            'date' => 'required|date',
            'meals.*.meal_id' => 'required|exists:meals,id',
        ];
    }
}
