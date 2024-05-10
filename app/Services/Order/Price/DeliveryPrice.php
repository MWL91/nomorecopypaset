<?php

namespace App\Services\Order\Price;

use App\Services\Order\Price\Price;
use Illuminate\Support\Facades\Http;

class DeliveryPrice implements Price
{
    public function __invoke(): float
    {
        $response = Http::get('https://example.com/takeaway_and_delivery_prices.json');
        return $response->json('price');
    }

    public function getDeliveryCost(int $distance): float
    {
        return $distance * 1; // Tak jak poprzednio
    }
}
