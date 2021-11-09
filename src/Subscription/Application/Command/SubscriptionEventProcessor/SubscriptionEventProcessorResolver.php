<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Application\Command\SubscriptionEventProcessor;

use KiloHealth\Subscription\Domain\ValueObject\SubscriptionEvent;

class SubscriptionEventProcessorResolver
{
    public function __construct(
        private CancelSubscriptionProcessor $cancelSubscriptionProcessor,
        private FailedRenewSubscriptionProcessor $failedRenewSubscriptionProcessor,
        private InitialPaymentProcessor $initialPaymentProcessor,
        private RenewSubscriptionProcessor $renewSubscriptionProcessor,
    ) {
    }

    public function resolve(SubscriptionEvent $subscriptionEvent): SubscriptionEventProcessorInterface
    {
        return match ($subscriptionEvent->getValue()) {
            SubscriptionEvent::TYPE_INITIAL => $this->initialPaymentProcessor,
            SubscriptionEvent::TYPE_CANCEL => $this->cancelSubscriptionProcessor,
            SubscriptionEvent::TYPE_RENEW => $this->renewSubscriptionProcessor,
            SubscriptionEvent::TYPE_FAILED_RENEW => $this->failedRenewSubscriptionProcessor,
        };
    }
}
