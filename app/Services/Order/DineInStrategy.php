<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\User;
use App\Services\Order\Price\NoTransportPrice;
use App\Services\Order\Price\Price;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Http;

final class DineInStrategy extends OrderStrategy
{

    #[\Override] protected function getPrice(): Price
    {
        return new NoTransportPrice();
    }

    #[\Override] public function getType(): string
    {
        return 'dine_in';
    }
}
