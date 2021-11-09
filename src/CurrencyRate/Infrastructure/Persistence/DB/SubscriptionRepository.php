<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Infrastructure\Persistence\DB;

use Doctrine\DBAL\Connection;
use KiloHealth\Subscription\Domain\Entity\CurrencyRateCollection;
use KiloHealth\Subscription\Domain\Entity\CurrencyRatePack;
use KiloHealth\Subscription\Domain\Repository\SubscriptionRepositoryInterface;
use KiloHealth\Subscription\Domain\Service\CurrencyRateFactory;
use KiloHealth\Subscription\Domain\Service\CurrencyRatePackFactory;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCode;
use Phoenix\Payment\Lib\DateTimeImmutableFactory;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    private const TABLE_NAME = 'currencyRate';

    public function __construct(
        private Connection $connection,
        private DateTimeImmutableFactory $dateTimeImmutableFactory,
        private CurrencyRateFactory $currencyRateFactory,
        private CurrencyRatePackFactory $currencyRatePackFactory
    ) {
    }

    public function save(CurrencyRatePack $currencyRatePack): void
    {
        $sql = \sprintf(
            'INSERT INTO `%s` SET rateDate = :rateDate, currencyFrom = :currencyFrom,',
            self::TABLE_NAME
        );
        $params = [];
        $sqlParts = [];

        foreach ($currencyRatePack->getCurrencyRates() as $currencyRate) {
            $rateTo = "rateTo{$currencyRate->getCurrencyTo()->getValue()}";
            $placeholder = ":{$rateTo}";
            $sqlParts[] = "`{$rateTo}` = {$placeholder}";
            $params[$placeholder] = $currencyRate->getRate();
        }

        $params[':rateDate'] = $currencyRatePack->getRateDate()->format('Y-m-d');
        $params[':currencyFrom'] = $currencyRatePack->getCurrencyCodeFrom()->getValue();

        $fieldSetSql = \implode(',', $sqlParts);
        $sql .= " {$fieldSetSql} ON DUPLICATE KEY UPDATE $fieldSetSql";

        try {
            $this->connection
                ->prepare($sql)
                ->executeQuery($params);
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Cannot save currencies', 0, $exception);
        }
    }

    /**
     * @throws \RuntimeException
     */
    public function findPack(CurrencyCode $currencyCodeFrom, \DateTimeImmutable $rateDate): ?CurrencyRatePack
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        try {
            $dbResult = $queryBuilder
                ->select($this->getFullFieldList())
                ->from(self::TABLE_NAME)
                ->where('`currencyFrom` = :currencyFrom')
                ->andWhere('`rateDate` = :rateDate')
                ->setParameters([
                    ':currencyFrom' => $currencyCodeFrom->getValue(),
                    ':rateDate' => $rateDate->format('Y-m-d'),
                ])->execute()
                ->fetchAssociative();
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Cannot fetch currencies', 0, $exception);
        }

        $currencyRatePack = !empty($dbResult) ? $this->inflateCurrencyRatePack($dbResult) : null;

        return $currencyRatePack;
    }

    public function takePack(CurrencyCode $currencyCodeFrom, \DateTimeImmutable $rateDate): CurrencyRatePack
    {
        $currencyRatePack = $this->findPack($currencyCodeFrom, $rateDate);

        if (\is_null($currencyRatePack)) {
            throw new \RuntimeException(
                \sprintf(
                    'Currencies not found (currencyFrom = `%s`, rateDate = `%s`)',
                    $currencyCodeFrom->getValue(),
                    $rateDate->format('Y-m-d'),
                ),
            );
        }

        return $currencyRatePack;
    }

    private function inflateCurrencyRatePack(array $row): CurrencyRatePack
    {
        $currencyFrom = $row['currencyFrom']
            ?? throw new \OutOfBoundsException('Field `currencyFrom` does not exist in fieldset');
        $currencyFromEnum = CurrencyCode::getObject($currencyFrom);

        $rateDate = $row['rateDate']
            ?? throw new \OutOfBoundsException('Field `rateDate` does not exist in fieldset');
        $rateDate = $this->dateTimeImmutableFactory->create($rateDate);

        return $this->currencyRatePackFactory->create(
            $currencyFromEnum,
            $rateDate,
            $this->inflateCurrencyRates($currencyFromEnum, $rateDate, $row),
        );
    }

    private function inflateCurrencyRates(
        CurrencyCode $currencyFromEnum,
        \DateTimeImmutable $rateDate,
        array $row,
    ): CurrencyRateCollection {
        $currencyRates = new CurrencyRateCollection();

        foreach (CurrencyCode::getList() as $currencyCodeTo) {
            $field = "rateTo{$currencyCodeTo}";
            $rate = $row[$field]
                ?? throw new \RuntimeException("Field `$field` does not exist in fieldset");

            $currencyRate = $this->currencyRateFactory->create(
                $currencyFromEnum,
                CurrencyCode::getObject($currencyCodeTo),
                $rateDate,
                (float)$rate,
            );
            $currencyRates->addItem($currencyRate);
        }

        return $currencyRates;
    }

    private function getFullFieldList(): array
    {
        $fields = [
            'currencyFrom',
            'rateDate',
        ];

        foreach (CurrencyCode::getList() as $currencyCode) {
            $fields[] = "rateTo{$currencyCode}";
        }

        return $fields;
    }
}
