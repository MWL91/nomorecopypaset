<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Services\Order\Loyalty\LoyaltyStrategy;
use App\Services\Order\Loyalty\NoLoyaltyPoints;
use App\Services\Order\Loyalty\UseLoyaltyPoints;
use App\Services\Order\Price\DeliveryPrice;
use App\Services\Order\Price\Price;
use Illuminate\Contracts\Auth\Authenticatable;

final class DeliveryStrategy extends OrderStrategy
{
    #[\Override] protected function getPrice(): Price
    {
        return new DeliveryPrice();
    }

    #[\Override] public function getType(): string
    {
        return 'delivery';
    }
}
