<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'available_quantity',
        'price',
        'discount',
    ];

    public function mealStock() 
    {
        return $this->hasMany(MealStock::class, 'meal_id');
    }

    public function todayMealStock()
    {
        return $this->mealStock()->whereDate('date', date('Y-m-d'))->first();
    }

    public function getAvailableQuantityAttribute()
    {
        if ($this->todayMealStock()) {
           return  $this->todayMealStock()->available_quantity;
        }

        return $this->attributes['available_quantity']; 
    }

    public function getPriceAfterDiscountAttribute() 
    {
        return $this->attributes['price'] - $this->discount; 
    }
}
