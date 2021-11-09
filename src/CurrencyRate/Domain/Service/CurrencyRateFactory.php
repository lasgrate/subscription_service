<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Service;

use KiloHealth\Subscription\Domain\Entity\CurrencyRate;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCode;

class CurrencyRateFactory
{
    private const DEFAULT_CURRENCY_RATE = 0.0;
    private const SELF_CURRENCY_RATE = 1.0;

    public function create(
        CurrencyCode $currencyCodeFrom,
        CurrencyCode $currencyCodeTo,
        \DateTimeImmutable $rateDate,
        float $rate = null
    ): CurrencyRate {
        if (!\is_null($rate) && self::SELF_CURRENCY_RATE !== $rate && $currencyCodeFrom->isEqual($currencyCodeTo)) {
            throw new \LogicException('Invalid rate to self currency');
        } elseif (\is_null($rate) && $currencyCodeFrom->isEqual($currencyCodeTo)) {
            $rate = self::SELF_CURRENCY_RATE;
        } elseif (\is_null($rate)) {
            $rate = self::DEFAULT_CURRENCY_RATE;
        }

        return new CurrencyRate($currencyCodeFrom, $currencyCodeTo, $rateDate, $rate);
    }
}
