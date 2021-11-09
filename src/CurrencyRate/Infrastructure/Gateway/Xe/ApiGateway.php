<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Infrastructure\Gateway\Xe;

use KiloHealth\Subscription\Domain\Entity\CurrencyRateCollection;
use KiloHealth\Subscription\Domain\Service\GatewayInterface;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCode;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCodeSet;
use KiloHealth\Subscription\Infrastructure\Gateway\Xe\Endpoint\AccountInfoEndpoint;
use KiloHealth\Subscription\Infrastructure\Gateway\Xe\Endpoint\HistoricRateEndpoint;
use KiloHealth\Subscription\Infrastructure\Gateway\Xe\Parser\AccountInfoResponseParser;
use KiloHealth\Subscription\Infrastructure\Gateway\Xe\Parser\HistoricRateResponseParser;
use KiloHealth\Subscription\Infrastructure\Policy\PackageRemainingPolicy;
use Psr\Log\LoggerInterface;

class ApiGateway implements GatewayInterface
{
    public function __construct(
        private AccountInfoEndpoint $accountInfoEndpoint,
        private AccountInfoResponseParser $accountInfoResponseParser,
        private HistoricRateEndpoint $historicRateEndpoint,
        private HistoricRateResponseParser $historicRateResponseParser,
        private PackageRemainingPolicy $packageRemainingPolicy,
        private CurrencyRateCollectionFactory $currencyRateCollectionFactory,
        private LoggerInterface $logger
    ) {
    }

    public function fetchCurrencyRates(
        \DateTimeImmutable $rateDate,
        CurrencyCode $currencyCodeFrom,
        CurrencyCodeSet $currencyCodesTo
    ): CurrencyRateCollection {
        $this->checkPackagePolicy();

        $response = $this->historicRateEndpoint->call(
            $currencyCodeFrom->getValue(),
            $currencyCodesTo->getValueArray(),
            $rateDate
        );

        $currencyRateDto = $this->historicRateResponseParser->parse($response);

        return $this->currencyRateCollectionFactory->create(
            $currencyRateDto,
            $rateDate,
            $currencyCodeFrom,
            $currencyCodesTo
        );
    }

    private function checkPackagePolicy(): void
    {
        $response = $this->accountInfoEndpoint->call();
        $accountInfoDto = $this->accountInfoResponseParser->parse($response);

        if (!$this->packageRemainingPolicy->isPackagesEnough($accountInfoDto->getPackageLimitRemaining())) {
            $this->logger->emergency('No packages left on XE.com account');

            throw new \RuntimeException('No packages left on XE.com account');
        }

        if ($this->packageRemainingPolicy->isExceedPackageLimit($accountInfoDto->getPackageLimitRemaining())) {
            $this->logger->emergency('XE.com package limit exceed', [
                'packageLimitRemaining' => $accountInfoDto->getPackageLimitRemaining(),
            ]);
        }
    }
}
