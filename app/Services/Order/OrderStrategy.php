<?php
declare(strict_types=1);

namespace App\Services\Order;

use App\Dtos\OrderData;
use App\Models\Order;
use App\Services\Order\Loyalty\LoyaltyStrategy;
use App\Services\Order\Loyalty\NoLoyaltyPoints;
use App\Services\Order\Loyalty\UseLoyaltyPoints;
use App\Services\Order\Price\Price;
use Illuminate\Contracts\Auth\Authenticatable;

abstract class OrderStrategy
{
    abstract public function getType(): string;

    public function isSatisfiedBy(OrderData $orderData): bool
    {
        return $orderData->getOrderType() === $this->getType();
    }

    public function exec(OrderData $orderData) {
        $price = $this->getPrice();
        $loyaltyStrategy = $this->getLoyaltyStrategy($orderData->isUseLoyaltyPoints(), $orderData->getUser());

        $order = new Order();
        $order->type = $this->getType();
        $order->price = $loyaltyStrategy->exec($price(), $orderData->getUser());
        $order->delivery_cost = $price->getDeliveryCost($orderData->getDistance());
        $order->user_id = $user->id ?? null;
        $order->total_price = $order->price + $order->delivery_cost;
        $order->save();
    }

    abstract protected function getPrice(): Price;

    public function getLoyaltyStrategies(): array
    {
        return [
            UseLoyaltyPoints::class,
            NoLoyaltyPoints::class
        ];
    }

    private function getLoyaltyStrategy(
        bool $useLoyaltyPoints,
        Authenticatable $user
    ): LoyaltyStrategy
    {
        foreach($this->getLoyaltyStrategies() as $strategy) {
            $strategy = new $strategy();
            if ($strategy->isSatisfiedBy($useLoyaltyPoints, $user)) {
                return $strategy;
            }
        }

        throw new \Exception('No strategy found');
    }

}
