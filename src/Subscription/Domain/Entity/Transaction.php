<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Entity;

use KiloHealth\Subscription\Domain\ValueObject\PaymentGateway;
use KiloHealth\Subscription\Domain\ValueObject\Status;
use KiloHealth\Subscription\Domain\ValueObject\SubscriptionId;
use KiloHealth\Subscription\Domain\ValueObject\TransactionId;

class Transaction
{
    public function __construct(
        private TransactionId $transactionId,
        private SubscriptionId $subscriptionId,
        private Status $status,
        private PaymentGateway $paymentGateway
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

    public function getPaymentGateway(): PaymentGateway
    {
        return $this->paymentGateway;
    }
}
