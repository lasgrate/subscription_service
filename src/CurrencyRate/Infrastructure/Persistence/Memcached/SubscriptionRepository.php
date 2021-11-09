<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Infrastructure\Persistence\Memcached;

use KiloHealth\Subscription\Domain\Entity\CurrencyRatePack;
use KiloHealth\Subscription\Domain\Repository\SubscriptionRepositoryInterface;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCode;
use Psr\Cache\InvalidArgumentException as InvalidArgumentExceptionAlias;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    private const TTL = 300;

    public function __construct(
        private CacheInterface $cache,
        private SubscriptionRepositoryInterface $currencyRateRepository
    ) {
    }

    /**
     * @throws InvalidArgumentExceptionAlias
     */
    public function save(CurrencyRatePack $currencyRatePack): void
    {
        $cacheKey = $this->createKey($currencyRatePack->getCurrencyCodeFrom(), $currencyRatePack->getRateDate());
        $this->cache->delete($cacheKey);
        $this->currencyRateRepository->save($currencyRatePack);
    }

    /**
     * @throws InvalidArgumentExceptionAlias
     */
    public function takePack(CurrencyCode $currencyCodeFrom, \DateTimeImmutable $rateDate): CurrencyRatePack
    {
        return $this->cache->get(
            $this->createKey($currencyCodeFrom, $rateDate),
            function (ItemInterface $item) use ($currencyCodeFrom, $rateDate) {
                $item->expiresAfter(self::TTL);
                return $this->currencyRateRepository->takePack($currencyCodeFrom, $rateDate);
            }
        );
    }

    /**
     * @throws InvalidArgumentExceptionAlias
     */
    public function findPack(CurrencyCode $currencyCodeFrom, \DateTimeImmutable $rateDate): ?CurrencyRatePack
    {
        return $this->cache->get(
            $this->createKey($currencyCodeFrom, $rateDate),
            function (ItemInterface $item) use ($currencyCodeFrom, $rateDate) {
                $item->expiresAfter(self::TTL);
                return $this->currencyRateRepository->findPack($currencyCodeFrom, $rateDate);
            }
        );
    }

    private function createKey(CurrencyCode $currencyCodeFrom, \DateTimeImmutable $rateDate): string
    {
        return \md5($currencyCodeFrom->getValue() . $rateDate->format('Y-m-d'));
    }
}
