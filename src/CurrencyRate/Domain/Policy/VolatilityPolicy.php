<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Policy;

class VolatilityPolicy
{
    public function __construct(private float $threshold)
    {
        if ($threshold < 0) {
            throw new \InvalidArgumentException('Argument `threshold` must not be less then zero');
        }
    }

    public function isAcceptable(float $previousRate, float $actualRate): bool
    {
        if ($previousRate < 0) {
            throw new \InvalidArgumentException('Argument `previousRate` must not be less then zero');
        }

        if ($actualRate < 0) {
            throw new \InvalidArgumentException('Argument `actualRate` must not be less then zero');
        }

        $isAcceptable = true;

        if (0.0 !== $previousRate) {
            $isAcceptable = \abs($actualRate - $previousRate) / $previousRate <= $this->threshold;
        }

        return $isAcceptable;
    }
}
