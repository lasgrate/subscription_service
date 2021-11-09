<?php

namespace KiloHealth\Subscription\Domain\ValueObject;

use KiloHealth\Lib\AbstractEnum;

/**
 * @method static SubscriptionEvent getObject(string $type)
 */
class SubscriptionEvent extends AbstractEnum
{
    public const TYPE_CANCEL = 'cancel';
    public const TYPE_INITIAL = 'initial';
    public const TYPE_RENEW = 'renew';
    public const TYPE_FAILED_RENEW = 'failedRenew';
}
