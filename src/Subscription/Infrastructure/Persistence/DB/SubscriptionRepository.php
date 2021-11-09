<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Infrastructure\Persistence\DB;

use Doctrine\DBAL\Connection;
use KiloHealth\Lib\UuidGenerator;
use KiloHealth\Subscription\Domain\Entity\Subscription;
use KiloHealth\Subscription\Domain\Repository\SubscriptionRepositoryInterface;
use KiloHealth\Subscription\Domain\ValueObject\SubscriptionId;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    private const TABLE_NAME = 'subscriptions';

    public function __construct(
        private UuidGenerator $uuidGenerator,
        private Connection $connection,
    ) {
    }

    public function generateSubscriptionId(): SubscriptionId
    {
        return new SubscriptionId($this->uuidGenerator->generate());
    }

    public function save(Subscription $subscription): void
    {
        $sql = "
            INSERT INTO
                :table_name
            SET subscriptionId = unhex(:subscriptionId),
                reference = :reference
                expiredAt = :expiredAt
        ";

        try {
            $this->connection
                ->prepare($sql)
                ->executeQuery(
                    [
                        'table_name' => self::TABLE_NAME,
                        'subscriptionId' => $subscription->getSubscriptionId()->toHexadecimal(),
                        'reference' => $subscription->getReference(),
                        'expiredAt' => $subscription->getExpiredAt()->format('Y-m-d H:i:s'),
                    ]
                );
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Cannot execute query', 0, $exception);
        }
    }

    public function updateExpiredAt(SubscriptionId $subscriptionId, \DateTimeImmutable $expiredAt): void
    {
        try {
            $this->connection
                ->createQueryBuilder()
                ->update(self::TABLE_NAME)
                ->set('expiredAt', $this->dateTimeToSql($expiredAt))
                ->where('`subscriptionId` = unhex(:subscriptionId)')
                ->setParameter('subscriptionId', $subscriptionId->toHexadecimal())
                ->execute();
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Cannot execute query', 0, $exception);
        }
    }

    public function findByReference(string $reference): ?Subscription
    {
        try {
            $dbResult = $this->connection
                ->createQueryBuilder()
                ->select(
                    [
                        'subscriptionId',
                        'reference',
                        'expiredAt',
                    ]
                )->from(self::TABLE_NAME)
                ->where('`reference` = :reference')
                ->setParameter('reference', $reference)
                ->execute()
                ->fetchAssociative();
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Cannot execute query', 0, $exception);
        }

        $result = !empty($dbResult) ? $this->inflate($dbResult) : null;

        return $result;
    }

    private function inflate(array $row): Subscription
    {
        foreach (['subscriptionId', 'reference', 'expiredAt'] as $key) {
            if (!\array_key_exists($key, $row)) {
                throw new \OutOfBoundsException("Missing key `$key` in row");
            }
        }

        return new Subscription(
            new SubscriptionId($row['subscriptionId']),
            $row['reference'],
            new \DateTimeImmutable($row['expiredAt']),
        );
    }

    private function dateTimeToSql(\DateTimeImmutable $dateTime): string
    {
        return $dateTime->format('Y-m-d H:i:s');
    }
}
