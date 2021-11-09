<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Infrastructure\Persistence\DB;

use Doctrine\DBAL\Connection;
use KiloHealth\Lib\UuidGenerator;
use KiloHealth\Subscription\Domain\Entity\Transaction;
use KiloHealth\Subscription\Domain\Repository\TransactionRepositoryInterface;
use KiloHealth\Subscription\Domain\ValueObject\TransactionId;

class TransactionRepository implements TransactionRepositoryInterface
{
    private const TABLE_NAME = 'transactions';

    public function __construct(
        private UuidGenerator $uuidGenerator,
        private Connection $connection,
    ) {
    }

    public function generateTransactionId(): TransactionId
    {
        return new TransactionId($this->uuidGenerator->generate());
    }

    public function save(Transaction $transaction): void
    {
        $sql = "
            INSERT INTO
                :table_name
            SET transactionId = unhex(:transactionId),
                subscriptionId = unhex(:subscriptionId),
                status = :status
                paymentGateway = :paymentGateway
        ";

        try {
            $this->connection
                ->prepare($sql)
                ->executeQuery(
                    [
                        'table_name' => self::TABLE_NAME,
                        'transactionId' => $transaction->getTransactionId()->toHexadecimal(),
                        'subscriptionId' => $transaction->getSubscriptionId()->toHexadecimal(),
                        'status' => $transaction->getStatus()->getValue(),
                        'paymentGateway' => $transaction->getPaymentGateway()->getValue(),
                    ]
                );
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Cannot execute query', 0, $exception);
        }
    }
}
