<?php

declare(strict_types=1);

namespace Phoenix\Payment\Lib;

class DateTimeImmutableFactory
{
    public function create(string $datetime = 'now', \DateTimeZone $timezone = null): \DateTimeImmutable
    {
        return new \DateTimeImmutable($datetime, $timezone);
    }
}
