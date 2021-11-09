<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Entity;

use KiloHealth\Subscription\Domain\ValueObject\Psp;
use KiloHealth\Subscription\Domain\ValueObject\Status;
use KiloHealth\Subscription\Domain\ValueObject\SubscriptionId;
use KiloHealth\Subscription\Domain\ValueObject\TransactionId;

class Transaction
{
    public function __construct(
        private TransactionId $transactionId,
        private SubscriptionId $subscriptionId,
        private Status $status,
        private Psp $psp
    ) {
    }

    public function getTransactionId(): TransactionId
    {
        return $this->transactionId;
    }

    public function getSubscriptionId(): SubscriptionId
    {
        return $this->subscriptionId;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getPsp(): Psp
    {
        return $this->psp;
    }
}
