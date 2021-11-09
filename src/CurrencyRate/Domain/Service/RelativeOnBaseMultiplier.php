<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Service;

use KiloHealth\Subscription\Domain\Entity\CurrencyRateCollection;
use KiloHealth\Subscription\Domain\Entity\CurrencyRatePack;

class RelativeOnBaseMultiplier
{
    public function __construct(
        private CurrencyRateFactory $currencyRateFactory,
        private CurrencyRatePackFactory $currencyRatePackFactory,
    ) {
    }

    /**
     * @return iterable|CurrencyRatePack[]
     */
    public function multiply(CurrencyRatePack $currencyRatePack): iterable
    {
        foreach ($currencyRatePack->getCurrencyRates() as $currencyRateFrom) {
            $relativeCurrencyRateCollection = new CurrencyRateCollection();
            $currencyRateCollectionCopy = clone $currencyRatePack->getCurrencyRates();

            foreach ($currencyRateCollectionCopy as $currencyRateTo) {
                $rate = null;

                if ($currencyRateFrom->getRate() !== 0.0) {
                    $rate = $currencyRateTo->getRate() / $currencyRateFrom->getRate();
                }

                $relativeCurrencyRateCollection->addItem(
                    $this->currencyRateFactory->create(
                        $currencyRateFrom->getCurrencyTo(),
                        $currencyRateTo->getCurrencyTo(),
                        $currencyRatePack->getRateDate(),
                        $rate
                    )
                );
            }

            yield $this->currencyRatePackFactory->create(
                $currencyRateFrom->getCurrencyTo(),
                $currencyRatePack->getRateDate(),
                $relativeCurrencyRateCollection
            );
        }
    }
}
