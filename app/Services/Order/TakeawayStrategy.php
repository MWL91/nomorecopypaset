<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\User;
use App\Services\Order\Loyalty\NoLoyaltyPoints;
use App\Services\Order\Loyalty\UseLoyaltyPoints;
use App\Services\Order\Price\NoTransportPrice;
use App\Services\Order\Price\Price;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Http;

final class TakeawayStrategy extends OrderStrategy
{

    #[\Override] protected function getPrice(): Price
    {
        return new NoTransportPrice();
    }

    #[\Override] public function getType(): string
    {
        return 'takeaway';
    }

    public function getLoyaltyStrategies(): array
    {
        return [
            NoLoyaltyPoints::class
        ];
    }
}
