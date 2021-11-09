<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Application\Command;

use KiloHealth\Subscription\Application\Command\SubscriptionEventProcessor\SubscriptionEventProcessorResolver;
use KiloHealth\Subscription\Application\Dto\Callback\PaymentProviderNotification;
use KiloHealth\Subscription\Domain\ValueObject\PaymentGateway;
use KiloHealth\Subscription\Domain\ValueObject\SubscriptionEvent;

class SubscriptionCallbackHandler
{
    public function __construct(
        private SubscriptionEventProcessorResolver $subscriptionEventProcessorResolver,
    ) {
    }

    public function handle(PaymentProviderNotification $requestDto): void
    {
        $subscriptionEvent = SubscriptionEvent::getObject($requestDto->getEventType());
        $psp = PaymentGateway::getObject($requestDto->getPaymentProvider());
        $eventProcessor = $this->subscriptionEventProcessorResolver->resolve($subscriptionEvent);

        foreach ($requestDto->getProducts() as $product) {
            $eventProcessor->process($psp, $product);
        }
    }
}
