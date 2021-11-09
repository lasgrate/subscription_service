<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Service\Provider;

use KiloHealth\Subscription\Domain\Entity\CurrencyRatePack;
use KiloHealth\Subscription\Domain\Repository\SubscriptionRepositoryInterface;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCode;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCodeSet;

class RepositoryProvider implements ProviderInterface
{
    public function __construct(
        private SubscriptionRepositoryInterface $currencyRateRepository
    ) {
    }

    public function provideIterable(
        \DateTimeImmutable $rateDate,
        CurrencyCodeSet $currencyCodesFrom = null
    ): iterable {
        $currencyCodesFrom = $currencyCodesFrom ?? CurrencyCodeSet::fromArray(CurrencyCode::getList());

        foreach ($currencyCodesFrom as $currencyCodeFrom) {
            yield $this->currencyRateRepository->takePack($currencyCodeFrom, $rateDate);
        }
    }

    public function provide(CurrencyCode $currencyCodeFrom, \DateTimeImmutable $rateDate): CurrencyRatePack
    {
        return $this->currencyRateRepository->takePack($currencyCodeFrom, $rateDate);
    }
}
