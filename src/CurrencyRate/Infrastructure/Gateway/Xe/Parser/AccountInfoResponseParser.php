<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Infrastructure\Gateway\Xe\Parser;

use KiloHealth\Subscription\Infrastructure\Gateway\Xe\Dto\AccountInfoDto;

class AccountInfoResponseParser
{
    public function parse(string $response): AccountInfoDto
    {
        $response = \json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        if (!\array_key_exists('package_limit', $response)) {
            throw new \OutOfBoundsException('Missing key `package_limit` in response');
        }

        if (!\array_key_exists('package_limit_remaining', $response)) {
            throw new \OutOfBoundsException('Missing key `package_limit_remaining` in response');
        }

        return new AccountInfoDto(
            (int)$response['package_limit'],
            (int)$response['package_limit_remaining'],
        );
    }
}
