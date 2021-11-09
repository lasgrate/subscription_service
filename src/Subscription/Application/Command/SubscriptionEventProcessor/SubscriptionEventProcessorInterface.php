<?php

namespace KiloHealth\Subscription\Application\Command\SubscriptionEventProcessor;

use KiloHealth\Subscription\Application\Dto\Callback\Product;
use KiloHealth\Subscription\Domain\ValueObject\Psp;

interface SubscriptionEventProcessorInterface
{
    public function process(Psp $psp, Product $product): void;
}
