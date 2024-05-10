<?php

namespace App\Services\Order\Loyalty;

use Illuminate\Contracts\Auth\Authenticatable;

final class NoLoyaltyPoints extends LoyaltyStrategy
{

    #[\Override] function isSatisfiedBy(bool $useLoyaltyPoints, Authenticatable $user): bool
    {
        return true;
    }

    #[\Override] function exec(float $price, Authenticatable $user): float
    {
        return $price;
    }
}
