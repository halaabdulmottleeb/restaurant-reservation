<?php

namespace App\Services\Checkout;

use App\Models\Order;

class TaxesAndServiceCheckout implements CheckoutStrategy 
{
    public function invoice($total)
    {
        $taxes =  0.14;
        $service = 0.20;

        return [ 
            'sub_total' => $total,
            'taxes' => $total * $taxes,
            'service' => $total * $service,
            'total'   => $total * (1 + $taxes + $service)
        ];
    }
}