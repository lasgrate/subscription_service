<?php

namespace KiloHealth\Subscription\Application\Command\SubscriptionEventProcessor;

use KiloHealth\Subscription\Application\Dto\Callback\Product;
use KiloHealth\Subscription\Domain\ValueObject\PaymentGateway;

interface SubscriptionEventProcessorInterface
{
    public function process(PaymentGateway $paymentGateway, Product $product): void;
}
