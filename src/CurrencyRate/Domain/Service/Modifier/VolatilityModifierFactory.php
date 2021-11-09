<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Service\Modifier;

use KiloHealth\Subscription\Domain\Policy\VolatilityPolicyFactory;
use KiloHealth\Subscription\Domain\Repository\SubscriptionRepositoryInterface;
use Psr\Log\LoggerInterface;

class VolatilityModifierFactory
{
    public function __construct(
        private SubscriptionRepositoryInterface $currencyRateRepository,
        private LoggerInterface $logger,
        private VolatilityPolicyFactory $volatilityPolicyFactory
    ) {
    }

    public function create(
        \DateInterval $volatilityInterval,
        float $volatilityRelativeThreshold
    ): VolatilityModifier {
        return new VolatilityModifier(
            $this->currencyRateRepository,
            $this->logger,
            $this->volatilityPolicyFactory->create($volatilityRelativeThreshold),
            $volatilityInterval
        );
    }
}
