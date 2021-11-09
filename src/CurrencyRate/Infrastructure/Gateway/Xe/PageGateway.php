<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Infrastructure\Gateway\Xe;

use KiloHealth\Subscription\Domain\Entity\CurrencyRateCollection;
use KiloHealth\Subscription\Domain\Service\GatewayInterface;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCode;
use KiloHealth\Subscription\Domain\ValueObject\CurrencyCodeSet;
use KiloHealth\Subscription\Infrastructure\Gateway\Xe\Endpoint\CurrencyPageEndpoint;
use KiloHealth\Subscription\Infrastructure\Gateway\Xe\Parser\CurrencyPageResponseParser;

class PageGateway implements GatewayInterface
{
    public function __construct(
        private CurrencyPageEndpoint $currencyPageEndpoint,
        private CurrencyPageResponseParser $historicRateResponseParser,
        private CurrencyRateCollectionFactory $currencyRateCollectionFactory,
    ) {
    }

    public function fetchCurrencyRates(
        \DateTimeImmutable $rateDate,
        CurrencyCode $currencyCodeFrom,
        CurrencyCodeSet $currencyCodesTo
    ): CurrencyRateCollection {
        $response = $this->currencyPageEndpoint->call($currencyCodeFrom->getValue(), $rateDate);
        $currencyRateDto = $this->historicRateResponseParser->parse($response);

        return $this->currencyRateCollectionFactory->create(
            $currencyRateDto,
            $rateDate,
            $currencyCodeFrom,
            $currencyCodesTo
        );
    }
}
