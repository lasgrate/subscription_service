<?php

namespace KiloHealth\Subscription\Domain\Entity;

use KiloHealth\Subscription\Domain\ValueObject\SubscriptionId;

class Subscription
{
    public function __construct(
        private SubscriptionId $subscriptionId,
        private string $pspReference,
        private \DateTimeImmutable $expiredAt
    ) {
    }

    public function getSubscriptionId(): SubscriptionId
    {
        return $this->subscriptionId;
    }

    public function getPspReference(): string
    {
        return $this->pspReference;
    }

    public function getExpiredAt(): \DateTimeImmutable
    {
        return $this->expiredAt;
    }
}
