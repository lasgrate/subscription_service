<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Service\Provider;

use KiloHealth\Subscription\Domain\Entity\CurrencyRateCollection;
use KiloHealth\Subscription\Domain\Entity\CurrencyRatePack;
use KiloHealth\Subscription\Domain\Service\CurrencyRateFactory;
use KiloHealth\Subscription\Domain\Service\CurrencyRatePackFactory;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCode;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCodeSet;
use Phoenix\Payment\Lib\Randomizer;

class FakeProvider implements ProviderInterface
{
    public function __construct(
        private CurrencyRateFactory $currencyRateFactory,
        private CurrencyRatePackFactory $currencyRatePackFactory,
        private Randomizer $randomizer
    ) {
    }

    public function provideIterable(
        \DateTimeImmutable $rateDate,
        CurrencyCodeSet $currencyCodesFrom = null
    ): iterable {
        $allCurrencies = CurrencyCodeSet::fromArray(CurrencyCode::getList());
        $currencyCodesFrom = $currencyCodesFrom ?? $allCurrencies;

        foreach ($currencyCodesFrom as $currencyCodeFrom) {
            $currencyCodesTo = $allCurrencies->remove($currencyCodeFrom);
            $currencyRates = new CurrencyRateCollection();

            foreach ($currencyCodesTo as $currencyCodeTo) {
                $randomRate = \floatval($this->randomizer->rand(1, 1000) / 10);
                $currencyRate = $this->currencyRateFactory->create(
                    $currencyCodeFrom,
                    $currencyCodeTo,
                    $rateDate,
                    $randomRate
                );
                $currencyRates->addItem($currencyRate);
            }

            yield $this->currencyRatePackFactory->create($currencyCodeFrom, $rateDate, $currencyRates);
        }
    }

    public function provide(CurrencyCode $currencyCodeFrom, \DateTimeImmutable $rateDate): CurrencyRatePack
    {
        $allCurrencies = CurrencyCodeSet::fromArray(CurrencyCode::getList());
        $currencyCodesTo = $allCurrencies->remove($currencyCodeFrom);
        $currencyRates = new CurrencyRateCollection();

        foreach ($currencyCodesTo as $currencyCodeTo) {
            $randomRate = \floatval($this->randomizer->rand(1, 1000) / 10);
            $currencyRate = $this->currencyRateFactory->create(
                $currencyCodeFrom,
                $currencyCodeTo,
                $rateDate,
                $randomRate
            );
            $currencyRates->addItem($currencyRate);
        }

        return $this->currencyRatePackFactory->create($currencyCodeFrom, $rateDate, $currencyRates);
    }
}
