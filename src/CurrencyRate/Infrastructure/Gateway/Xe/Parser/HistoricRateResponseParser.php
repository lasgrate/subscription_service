<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Infrastructure\Gateway\Xe\Parser;

use KiloHealth\Subscription\Infrastructure\Gateway\Xe\Dto\CurrencyRateDto;

class HistoricRateResponseParser
{
    /**
     * @throws \OutOfBoundsException
     * @throws \JsonException
     */
    public function parse(string $response): CurrencyRateDto
    {
        $response = \json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        if (!\array_key_exists('to', $response)) {
            throw new \OutOfBoundsException('Missing key `to` in response');
        }

        $rates = function () use ($response) {
            foreach ($response['to'] as $row) {
                if (!\array_key_exists('quotecurrency', $row)) {
                    throw new \OutOfBoundsException('Missing key `to[quotecurrency]` in response');
                }

                if (!\array_key_exists('mid', $row)) {
                    throw new \OutOfBoundsException('Missing key `to[mid]` in response');
                }

                yield $row['quotecurrency'] => (float)$row['mid'];
            }
        };

        return new CurrencyRateDto($rates());
    }
}
