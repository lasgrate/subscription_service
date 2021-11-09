<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Service\Modifier;

use KiloHealth\Subscription\Domain\Entity\CurrencyRatePack;

class RateDateModifier implements ModifierInterface
{
    public function __construct(
        private \DateTimeImmutable $rateDate
    ) {
    }

    public function modify(CurrencyRatePack $currencyRatePack): CurrencyRatePack
    {
        return $currencyRatePack->setRateDate($this->rateDate);
    }
}
