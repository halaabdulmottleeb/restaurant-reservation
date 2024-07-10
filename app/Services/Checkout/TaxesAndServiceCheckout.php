<?php

namespace App\Services\Checkout;

use App\Models\Order;

class TaxesAndServiceCheckout implements CheckoutStrategy 
{
    public function invoice($total)
    {
        $service = 0.15;

        return [ 
            'sub_total' => $total,
            'service' => $total * $service,
            'total'   => $total * (1 + $service)
        ];   
    }
}