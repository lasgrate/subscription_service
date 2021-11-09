<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Service\Modifier;

use KiloHealth\Subscription\Domain\Entity\CurrencyRatePack;

class NullModifier implements ModifierInterface
{
    public function modify(CurrencyRatePack $currencyRatePack): CurrencyRatePack
    {
        return clone $currencyRatePack;
    }
}
