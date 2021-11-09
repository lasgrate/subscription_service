<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Repository;

use KiloHealth\Subscription\Domain\Entity\Subscription;
use KiloHealth\Subscription\Domain\ValueObject\SubscriptionId;

interface SubscriptionRepositoryInterface
{
    public function generateSubscriptionId(): SubscriptionId;

    public function save(Subscription $subscription);

    public function updateExpiredAt(SubscriptionId $subscriptionId, \DateTimeImmutable $expiredAt);

    public function findByReference(string $reference): ?Subscription;
}
