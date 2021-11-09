<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Infrastructure\Policy;

class PackageRemainingPolicy
{
    private const MIN_PACKAGE_LIMIT_REMAINING = 400;

    public function isPackagesEnough(int $packageLimitRemaining): bool
    {
        $result = $packageLimitRemaining > 0;

        return $result;
    }

    public function isExceedPackageLimit(int $packageLimitRemaining): bool
    {
        $result = $packageLimitRemaining <= self::MIN_PACKAGE_LIMIT_REMAINING;

        return $result;
    }
}
