<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Infrastructure\Gateway\Xe\Dto;

class AccountInfoDto
{
    public function __construct(
        private int $packageLimit,
        private int $packageLimitRemaining
    ) {
    }

    public function getPackageLimit(): int
    {
        return $this->packageLimit;
    }

    public function getPackageLimitRemaining(): int
    {
        return $this->packageLimitRemaining;
    }
}
