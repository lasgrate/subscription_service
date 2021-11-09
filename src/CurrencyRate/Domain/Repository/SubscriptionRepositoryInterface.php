<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Repository;

use KiloHealth\Subscription\Domain\Entity\CurrencyRatePack;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCode;

interface SubscriptionRepositoryInterface
{
    public function save(CurrencyRatePack $currencyRatePack): void;
}
