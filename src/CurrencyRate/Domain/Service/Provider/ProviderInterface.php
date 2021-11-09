<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Service\Provider;

use KiloHealth\Subscription\Domain\Entity\CurrencyRatePack;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCode;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCodeSet;

interface ProviderInterface
{
    /**
     * @return iterable|CurrencyRatePack[]
     */
    public function provideIterable(
        \DateTimeImmutable $rateDate,
        CurrencyCodeSet $currencyCodesFrom = null
    ): iterable;

    public function provide(CurrencyCode $currencyCodeFrom, \DateTimeImmutable $rateDate): CurrencyRatePack;
}
