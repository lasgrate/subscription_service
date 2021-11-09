<?php

namespace KiloHealth\Subscription\Domain\Entity;

use KiloHealth\Subscription\Domain\ValueObject\SubscriptionId;

class Subscription
{
    public function __construct(
        private SubscriptionId $subscriptionId,
        private string $reference,
        private \DateTimeImmutable $expiredAt
    ) {
    }

    public function getSubscriptionId(): SubscriptionId
    {
        return $this->subscriptionId;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getExpiredAt(): \DateTimeImmutable
    {
        return $this->expiredAt;
    }
}
