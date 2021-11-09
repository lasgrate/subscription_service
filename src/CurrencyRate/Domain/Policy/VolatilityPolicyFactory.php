<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Policy;

class VolatilityPolicyFactory
{
    public function create(float $threshold): VolatilityPolicy
    {
        return new VolatilityPolicy($threshold);
    }
}
