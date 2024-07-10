<?php

namespace App\Services\Checkout;

interface CheckoutStrategy 
{
    public function invoice($total);
}