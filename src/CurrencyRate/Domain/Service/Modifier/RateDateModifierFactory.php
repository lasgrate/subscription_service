<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Service\Modifier;

class RateDateModifierFactory
{
    public function create(\DateTimeImmutable $rateDate): RateDateModifier
    {
        return new RateDateModifier($rateDate);
    }
}
