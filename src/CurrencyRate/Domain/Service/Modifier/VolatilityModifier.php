<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Service\Modifier;

use KiloHealth\Subscription\Domain\Entity\CurrencyRatePack;
use KiloHealth\Subscription\Domain\Policy\VolatilityPolicy;
use KiloHealth\Subscription\Domain\Repository\SubscriptionRepositoryInterface;
use Psr\Log\LoggerInterface;

class VolatilityModifier implements ModifierInterface
{
    public function __construct(
        private SubscriptionRepositoryInterface $currencyRateRepository,
        private LoggerInterface $logger,
        private VolatilityPolicy $volatilityPolicy,
        private \DateInterval $volatilityInterval
    ) {
    }

    public function modify(CurrencyRatePack $currencyRatePack): CurrencyRatePack
    {
        $previousCurrencyRatePack = $this->currencyRateRepository->findPack(
            $currencyRatePack->getCurrencyCodeFrom(),
            $currencyRatePack->getRateDate()->sub($this->volatilityInterval),
        );

        if (!\is_null($previousCurrencyRatePack)) {
            foreach ($currencyRatePack->getCurrencyRates() as $actualCurrencyRate) {
                $previousCurrencyRate = $previousCurrencyRatePack->get($actualCurrencyRate->getCurrencyTo());
                $isAcceptable = $this->volatilityPolicy->isAcceptable(
                    $previousCurrencyRate->getRate(),
                    $actualCurrencyRate->getRate()
                );

                if (false === $isAcceptable) {
                    $actualCurrencyRate = $actualCurrencyRate->setRate($previousCurrencyRate->getRate());
                    $currencyRatePack = $currencyRatePack->replace($actualCurrencyRate);
                    $this->logger->critical(
                        \sprintf(
                            'Subscription from `%s` to `%s` has changed a lot. Saved rate from `%s` date',
                            $actualCurrencyRate->getCurrencyFrom()->getValue(),
                            $actualCurrencyRate->getCurrencyTo()->getValue(),
                            $previousCurrencyRate->getRateDate()->format('Y-m-d',)
                        )
                    );
                }
            }
        }

        return $currencyRatePack;
    }
}
