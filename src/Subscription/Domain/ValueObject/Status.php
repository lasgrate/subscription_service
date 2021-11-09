<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\ValueObject;

use KiloHealth\Lib\AbstractEnum;

/**
 * @method static Status getObject(string $status)
 */
class Status extends AbstractEnum
{
    public const STATUS_CHARGED = 'charged';
    public const STATUS_DECLINED = 'declined';
}
