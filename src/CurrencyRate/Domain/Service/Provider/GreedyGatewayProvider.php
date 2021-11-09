<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Service\Provider;

use KiloHealth\Subscription\Domain\Entity\CurrencyRateCollection;
use KiloHealth\Subscription\Domain\Entity\CurrencyRatePack;
use KiloHealth\Subscription\Domain\Service\CurrencyRatePackFactory;
use KiloHealth\Subscription\Domain\Service\GatewayInterface;
use KiloHealth\Subscription\Domain\Service\RelativeOnBaseMultiplier;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCode;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCodeSet;

class GreedyGatewayProvider implements ProviderInterface
{
    private const DEFAULT_CURRENCY_FROM = CurrencyCode::CUR_USD;
    private const DEFAULT_MAIN_CURRENCY_CODES = [
        CurrencyCode::CUR_EUR,
        CurrencyCode::CUR_AUD,
        CurrencyCode::CUR_GBP,
    ];

    private CurrencyCodeSet $mainCurrencyCodes;

    public function __construct(
        private GatewayInterface $gateway,
        private ProviderInterface $commonProvider,
        private CurrencyRatePackFactory $currencyRatePackFactory,
        private RelativeOnBaseMultiplier $relativeOnBaseMultiplier,
        CurrencyCodeSet $mainCurrencyCodes = null
    ) {
        $this->mainCurrencyCodes = $mainCurrencyCodes
            ?? CurrencyCodeSet::fromArray(self::DEFAULT_MAIN_CURRENCY_CODES);
    }

    public function provideIterable(
        \DateTimeImmutable $rateDate,
        CurrencyCodeSet $currencyCodesFrom = null
    ): iterable {
        $usdCurrencyRatePack = $this->commonProvider->provide(
            CurrencyCode::getObject(self::DEFAULT_CURRENCY_FROM),
            $rateDate
        );

        $mainCurrencyRates = new CurrencyRateCollection();

        foreach ($this->mainCurrencyCodes as $currencyCodeFrom) {
            $currencyCodesTo = $this->mainCurrencyCodes->remove($currencyCodeFrom);
            $currencyRates = $this->gateway->fetchCurrencyRates($rateDate, $currencyCodeFrom, $currencyCodesTo);
            $mainCurrencyRates = $mainCurrencyRates->merge($currencyRates);
        }

        foreach ($this->relativeOnBaseMultiplier->multiply($usdCurrencyRatePack) as $currencyRatePack) {
            foreach ($mainCurrencyRates as $mainCurrencyRate) {
                $currencyRatePack = $currencyRatePack->replace($mainCurrencyRate);
            }

            if (\is_null($currencyCodesFrom) || $currencyCodesFrom->contain($currencyRatePack->getCurrencyCodeFrom())) {
                yield $currencyRatePack;
            }
        }
    }

    public function provide(CurrencyCode $currencyCodeFrom, \DateTimeImmutable $rateDate): CurrencyRatePack
    {
        return $this->commonProvider->provide($currencyCodeFrom, $rateDate);
    }
}
