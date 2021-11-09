<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Application\Command\SubscriptionEventProcessor;

use KiloHealth\Subscription\Application\Dto\Callback\Product;
use KiloHealth\Subscription\Domain\Repository\SubscriptionRepositoryInterface;
use KiloHealth\Subscription\Domain\ValueObject\PaymentGateway;

class CancelSubscriptionProcessor implements SubscriptionEventProcessorInterface
{
    public function __construct(
        private SubscriptionRepositoryInterface $subscriptionRepository,
    ) {
    }

    public function process(PaymentGateway $paymentGateway, Product $product): void
    {
        $subscription = $this->subscriptionRepository->findByReference($product->getReference());

        if (\is_null($subscription)) {
            throw new \UnexpectedValueException('Subscription not found');
        }

        // Do staff according to business logic
    }
}
