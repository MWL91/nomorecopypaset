<?php

namespace App\Services\Order\Loyalty;

use Illuminate\Contracts\Auth\Authenticatable;

abstract class LoyaltyStrategy
{
    abstract function isSatisfiedBy(bool $useLoyaltyPoints, Authenticatable $user): bool;

    abstract function exec(float $price, Authenticatable $user): float;
}
