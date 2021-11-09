<?php

declare(strict_types=1);

namespace KiloHealth\Lib;

abstract class AbstractUuid
{
    private string $hex;

    public function __construct(string $uuid)
    {
        if ('' === $uuid) {
            throw new \InvalidArgumentException('Empty uuid provided');
        }

        switch (\strlen($uuid)) {
            case 16:
                $this->hex = \bin2hex($uuid);
                break;
            case 32: //Hexadecimal without dashes
                if (!\ctype_xdigit($uuid)) {
                    throw new \InvalidArgumentException('Provided value is not hexadecimal. Received ' . $uuid);
                }

                $this->hex = $uuid;
                break;
            default:
                throw new \InvalidArgumentException('Unknown value format. Received ' . $uuid);
        }
    }

    public function toHexadecimal(): string
    {
        return $this->hex;
    }

    public function toBinary(): string
    {
        return \hex2bin($this->hex);
    }

    public function __toString(): string
    {
        return $this->toHexadecimal();
    }
}
