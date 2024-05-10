<?php

namespace App\Services\Order\Price;

use Illuminate\Support\Facades\Http;

class NoTransportPrice implements Price
{
    public function __invoke(): float
    {
        $response = Http::get('https://example.com/dine_in_prices.json');
        return $response->json('price');
    }

    public function getDeliveryCost(int $distance): float
    {
        return 0;
    }
}
