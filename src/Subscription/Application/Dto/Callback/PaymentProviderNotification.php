<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Application\Dto\Callback;

class PaymentProviderNotification
{
    public function __construct(
        private string $paymentProvider,
        private string $eventType,
        private ProductCollection $products
    ) {
    }

    public function getPaymentProvider(): string
    {
        return $this->paymentProvider;
    }

    public function getEventType(): string
    {
        return $this->eventType;
    }

    public function getProducts(): ProductCollection
    {
        return $this->products;
    }
}
