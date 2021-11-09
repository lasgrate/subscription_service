<?php

declare(strict_types=1);

namespace KiloHealth\Lib;

class UuidGenerator
{
    public function generate(): string
    {
        return \bin2hex(\random_bytes(16));
    }
}
