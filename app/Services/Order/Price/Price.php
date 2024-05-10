<?php

namespace App\Services\Order\Price;

interface Price
{
    public function __invoke(): float;

    public function getDeliveryCost(int $distance): float;
}
