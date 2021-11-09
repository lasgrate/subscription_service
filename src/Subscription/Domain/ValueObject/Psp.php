<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\ValueObject;

use KiloHealth\Lib\AbstractEnum;

/**
 * @method static Psp getObject(string $psp)
 */
class Psp extends AbstractEnum
{
    public const PSP_APPLE_PAY = 'applePay';
}