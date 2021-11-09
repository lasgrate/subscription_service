<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Infrastructure\Gateway\Xe\Parser;

use KiloHealth\Subscription\Infrastructure\Gateway\Xe\Dto\CurrencyRateDto;

class CurrencyPageResponseParser
{
    private const TABLE_PATTERN = "~<table class=\"currencytables__Table-.+\">(.+)</table>~sU";

    private const BODY_PATTERN = '~<tbody>(.+)</tbody>~sU';
    private const COMMENT_PATTERN = '~<!--.+-->~sU';

    private const CURRENCY_LIST_PATTERN = '~<th scope="row">'
        . '(<a href=".+" class="link__BaseLink-.+">)?(?<currencyCode>[^\<\>]+)(</a>)?'
        . '</th><td>.+</td><td>(?<unitsPerItem>[\d\.\,]+)</td><td>(?<itemsPerUnit>[\d\.\,]+)</td>~';

    public function parse(string $response): CurrencyRateDto
    {
        if ('' === $response) {
            throw new \RuntimeException('Unable to parse currencies - empty content');
        }

        if (!\preg_match(self::TABLE_PATTERN, $response, $match)) {
            throw new \RuntimeException('Unable to parse currencies - no currencies block found');
        }

        if (!\preg_match(self::BODY_PATTERN, $match[1], $match)) {
            throw new \RuntimeException('Unable to parse currencies - no tbody block found in currencies block');
        }

        $match[1] = \preg_replace(self::COMMENT_PATTERN, '', $match[1]);

        if (!\preg_match_all('~<tr>(.+)</tr>~sU', $match[1], $rows)) {
            throw new \RuntimeException('Unable to parse currencies - no rows found in tbody');
        }

        $rates = function () use ($rows) {
            foreach ($rows[1] as $row) {
                if (!\preg_match(self::CURRENCY_LIST_PATTERN, $row, $match)) {
                    throw new \RuntimeException('Unable to parse currencies - invalid row');
                }

                yield $match['currencyCode'] => (float)str_replace(',', '', $match['unitsPerItem']);
            }
        };

        return new CurrencyRateDto($rates());
    }
}
