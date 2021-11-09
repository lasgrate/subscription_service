<?php

declare(strict_types=1);

namespace KiloHealth\Lib;

class DateTimeImmutableFactory
{
    public function create(string $datetime = 'now', \DateTimeZone $timezone = null): \DateTimeImmutable
    {
        return new \DateTimeImmutable($datetime, $timezone);
    }
}
