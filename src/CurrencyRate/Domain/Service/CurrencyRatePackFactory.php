<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Service;

use KiloHealth\Subscription\Domain\Entity\CurrencyRateCollection;
use KiloHealth\Subscription\Domain\Entity\CurrencyRatePack;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCode;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCodeSet;

class CurrencyRatePackFactory
{
    public function __construct(private CurrencyRateFactory $currencyRateFactory)
    {
    }

    public function create(
        CurrencyCode $currencyCodeFrom,
        \DateTimeImmutable $rateDate,
        CurrencyRateCollection $currencyRateCollection
    ): CurrencyRatePack {
        if ($currencyRateCollection->count() !== \count(CurrencyCode::getList())) {
            $existedCurrencyToCodes = [];

            foreach ($currencyRateCollection as $currencyRate) {
                $existedCurrencyToCodes[] = $currencyRate->getCurrencyTo()->getValue();
            }

            $missedCurrencyToCodes = CurrencyCodeSet::fromArray(
                \array_diff(
                    CurrencyCode::getList(),
                    $existedCurrencyToCodes,
                )
            );

            foreach ($missedCurrencyToCodes as $currencyCodeTo) {
                $currencyRate = $this->currencyRateFactory->create(
                    $currencyCodeFrom,
                    $currencyCodeTo,
                    $rateDate,
                );
                $currencyRateCollection->addItem($currencyRate);
            }
        }

        return new CurrencyRatePack(
            $currencyCodeFrom,
            $rateDate,
            $currencyRateCollection
        );
    }
}
