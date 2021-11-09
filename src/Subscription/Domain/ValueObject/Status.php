<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\ValueObject;

use KiloHealth\Lib\AbstractUuid;

/**
 * @method static Status getObject(string $status)
 */
class Status extends AbstractUuid
{
    public const STATUS_CHARGED = 'charged';
    public const STATUS_DECLINED = 'declined';
}
