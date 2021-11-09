<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Service\Modifier;

use KiloHealth\Subscription\Domain\Entity\CurrencyRatePack;

interface ModifierInterface
{
    public function modify(CurrencyRatePack $currencyRatePack): CurrencyRatePack;
}
