<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Infrastructure\Gateway\Xe\Dto;

class CurrencyRateDto
{
    public function __construct(
        private iterable $rates
    ) {
    }

    /**
     * @return iterable|float[]
     */
    public function getRates(): iterable
    {
        return $this->rates;
    }
}
