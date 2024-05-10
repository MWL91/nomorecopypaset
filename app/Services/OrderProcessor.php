<?php

namespace App\Services;

use App\Dtos\OrderData;
use App\Models\Order;
use App\Models\User;
use App\Services\Order\DeliveryStrategy;
use App\Services\Order\DineInStrategy;
use App\Services\Order\OrderStrategy;
use App\Services\Order\TakeawayStrategy;
use Illuminate\Support\Facades\Http;

class OrderProcessor {

    private const array STRATEGIES = [
        DeliveryStrategy::class,
        TakeawayStrategy::class,
        DineInStrategy::class,
    ];

    public function processOrder(OrderData $orderData) {
        foreach(self::STRATEGIES as $strategy) {
            /** @var OrderStrategy $strategy */
            $strategy = new $strategy();
            if ($strategy->isSatisfiedBy($orderData)) {
                $strategy->exec($orderData);
                return;
            }
        }

        throw new \Exception('Unknown order type');
    }
}
