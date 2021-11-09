<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Infrastructure\Gateway\Xe\Endpoint;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HistoricRateEndpoint
{
    private const ENDPOINT = 'historic_rate.json';

    public function __construct(
        private HttpClientInterface $xeApiClient,
        private LoggerInterface $logger
    ) {
    }

    public function call(
        string $from,
        array $to,
        \DateTimeImmutable $rateDate
    ): string {
        try {
            $response = $this->xeApiClient->request('GET', self::ENDPOINT, [
                'query' => [
                    'from' => $from,
                    'to' => \implode(',', $to),
                    'date' => $rateDate->format('Y-m-d'),
                    'time' => $rateDate->format('H:i'),
                ],
            ]);

            $body = $response->getContent();
            $responseCode = $response->getStatusCode();
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Failed fetch currencies', 0, $exception);
        }

        if ($responseCode !== 200) {
            $this->logger->error('Xe.com API respond with not 200 OK status code', [
                'statusCode' => $responseCode,
                'body' => $body,
            ]);
            throw new \RuntimeException('Failed fetch currencies');
        }

        return $body;
    }
}
