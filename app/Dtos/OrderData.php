<?php

namespace App\Dtos;

use Illuminate\Contracts\Auth\Authenticatable;

class OrderData
{
    public function __construct(
        private Authenticatable $user,
        private string $orderType,
        private int $distance,
        private bool $useLoyaltyPoints = false
    )
    {
    }

    public function getUser(): Authenticatable
    {
        return $this->user;
    }

    public function getOrderType(): string
    {
        return $this->orderType;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }

    public function isUseLoyaltyPoints(): bool
    {
        return $this->useLoyaltyPoints;
    }


}
