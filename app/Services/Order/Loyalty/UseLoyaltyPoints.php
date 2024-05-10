<?php

namespace App\Services\Order\Loyalty;

use Illuminate\Contracts\Auth\Authenticatable;

final class UseLoyaltyPoints extends LoyaltyStrategy
{

    #[\Override] function isSatisfiedBy(bool $useLoyaltyPoints, Authenticatable $user): bool
    {
        return $useLoyaltyPoints && $user->loyalty_points > 0;
    }

    #[\Override] function exec(float $price, Authenticatable $user): float
    {
        $price -= $user->loyalty_points / 100; // Konwersja punktów na złotówki
        $user->loyalty_points = 0; // Zerowanie punktów po użyciu
        $user->save();

        return $price;
    }
}
