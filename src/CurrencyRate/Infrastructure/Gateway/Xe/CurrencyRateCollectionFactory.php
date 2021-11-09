<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Infrastructure\Gateway\Xe;

use KiloHealth\Subscription\Domain\Entity\CurrencyRateCollection;
use KiloHealth\Subscription\Domain\Service\CurrencyRateFactory;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCode;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCodeSet;
use KiloHealth\Subscription\Infrastructure\Gateway\Xe\Dto\CurrencyRateDto;

class CurrencyRateCollectionFactory
{
    public function __construct(
        private CurrencyRateFactory $currencyRateFactory,
    ) {
    }

    public function create(
        CurrencyRateDto $currencyRateDto,
        \DateTimeImmutable $rateDate,
        CurrencyCode $currencyCodeFrom,
        CurrencyCodeSet $currencyCodesTo
    ): CurrencyRateCollection {
        $currencyRates = new CurrencyRateCollection();

        foreach ($currencyRateDto->getRates() as $currencyTo => $rate) {
            if (
                CurrencyCode::inSet($currencyTo)
                && $currencyCodesTo->contain(CurrencyCode::getObject($currencyTo))
            ) {
                $currencyRate = $this->currencyRateFactory->create(
                    $currencyCodeFrom,
                    CurrencyCode::getObject($currencyTo),
                    $rateDate,
                    $rate
                );
                $currencyRates->addItem($currencyRate);
            }
        }

        return $currencyRates;
    }
}
