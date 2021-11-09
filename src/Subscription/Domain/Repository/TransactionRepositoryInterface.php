<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\Repository;

use KiloHealth\Subscription\Domain\Entity\Transaction;
use KiloHealth\Subscription\Domain\ValueObject\TransactionId;

interface TransactionRepositoryInterface
{
    public function generateTransactionId(): TransactionId;

    public function save(Transaction $transaction): void;
}
