<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Service\Provider;

use KiloHealth\Subscription\Domain\Entity\CurrencyRatePack;
use KiloHealth\Subscription\Domain\Service\CurrencyRatePackFactory;
use KiloHealth\Subscription\Domain\Service\GatewayInterface;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCode;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCodeSet;

class CommonGatewayProvider implements ProviderInterface
{
    public function __construct(
        private GatewayInterface $gateway,
        private CurrencyRatePackFactory $currencyRatePackFactory
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
            $currencyRates = $this->gateway->fetchCurrencyRates($rateDate, $currencyCodeFrom, $currencyCodesTo);

            yield $this->currencyRatePackFactory->create($currencyCodeFrom, $rateDate, $currencyRates);
        }
    }

    public function provide(CurrencyCode $currencyCodeFrom, \DateTimeImmutable $rateDate): CurrencyRatePack
    {
        $currencyCodesTo = CurrencyCodeSet::fromArray(CurrencyCode::getList())->remove($currencyCodeFrom);
        $currencyRates = $this->gateway->fetchCurrencyRates($rateDate, $currencyCodeFrom, $currencyCodesTo);

        return $this->currencyRatePackFactory->create($currencyCodeFrom, $rateDate, $currencyRates);
    }
}
