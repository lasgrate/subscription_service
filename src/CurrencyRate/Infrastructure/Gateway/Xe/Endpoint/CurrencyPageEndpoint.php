<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Infrastructure\Gateway\Xe\Endpoint;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CurrencyPageEndpoint
{
    private const ENDPOINT = 'currencytables/';

    public function __construct(
        private HttpClientInterface $xePageClient,
        private LoggerInterface $logger
    ) {
    }

    public function call(string $from, \DateTimeImmutable $rateDate): string
    {
        try {
            $response = $this->xePageClient->request('GET', self::ENDPOINT, [
                'query' => [
                    'from' => $from,
                    'date' => $rateDate->format('Y-m-d'),
                ],
            ]);
            $body = $response->getContent();
            $responseCode = $response->getStatusCode();
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Failed fetch account info', 0, $exception);
        }

        if ($responseCode !== 200) {
            $this->logger->error('Xe.com API respond with not 200 OK status code', [
                'statusCode' => $responseCode,
                'body' => $body,
            ]);
            throw new \RuntimeException('Failed fetch account info');
        }

        return $body;
    }
}
