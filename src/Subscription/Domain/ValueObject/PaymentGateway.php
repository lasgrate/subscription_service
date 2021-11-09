<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\ValueObject;

use KiloHealth\Lib\AbstractEnum;

/**
 * @method static PaymentGateway getObject(string $psp)
 */
class PaymentGateway extends AbstractEnum
{
    public const PSP_APPLE_PAY = 'applePay';
}