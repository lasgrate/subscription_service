<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Service;

use KiloHealth\Subscription\Domain\Entity\CurrencyRateCollection;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCode;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCodeSet;

interface GatewayInterface
{
    public function fetchCurrencyRates(
        \DateTimeImmutable $rateDate,
        CurrencyCode $currencyCodeFrom,
        CurrencyCodeSet $currencyCodesTo
    ): CurrencyRateCollection;
}
