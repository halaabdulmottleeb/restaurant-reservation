<?php

namespace App\Services\Checkout;

use App\Enums\OrderStrategiesEnum;
use App\Models\Order;

class CheckoutService
{
    protected CheckoutStrategy $strategy;

    public function __construct($strategyType)
    {
        $this->setStrategy($strategyType);
    }

    public function setStrategy($strategyType)
    {
        switch ($strategyType) {
            case OrderStrategiesEnum::TAXES_AND_SERVICES:
                $this->strategy = new TaxesAndServiceCheckout();
                break;
            case OrderStrategiesEnum::SERVICES_ONLY:
                $this->strategy = new ServiceChargeCheckout();
                break;
        }
    }

    public function invoice($total)
    {
        return $this->strategy->invoice($total);
    }
}
