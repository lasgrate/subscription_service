<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Application\Dto\Callback;

class ProductCollection implements \IteratorAggregate
{
    private array $products = [];

    public function __construct(Product ...$products)
    {
        $this->products = $products;
    }

    public function addItem(Product $product): void
    {
        $this->products[] = $product;
    }

    /**
     * @return \Traversable|Product[]
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->products);
    }
}