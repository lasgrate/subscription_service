<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Infrastructure\Persistence\DB;

use KiloHealth\Subscription\Domain\Repository\SubscriptionRepositoryInterface;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    private const TABLE_NAME = 'subscriptions';
}
