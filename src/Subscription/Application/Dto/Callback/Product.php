<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Application\Dto\Callback;

class Product
{
    public function __construct(
        private string $reference,
        private string $productId,
        private \DateTimeImmutable $expiredAt
    ) {
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getExpiredAt(): \DateTimeImmutable
    {
        return $this->expiredAt;
    }
}