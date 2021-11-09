<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\ValueObject;

class CurrencyCodeSet implements \IteratorAggregate, \Countable
{
    /**
     * @var array|CurrencyCode[]
     */
    private array $array = [];

    public function __construct(CurrencyCode ...$currencyCodes)
    {
        foreach ($currencyCodes as $currencyCode) {
            $this->addItem($currencyCode);
        }
    }

    public static function fromArray(array $currencies): self
    {
        $self = new self();

        foreach ($currencies as $currency) {
            $self->addItem(CurrencyCode::getObject($currency));
        }

        return $self;
    }

    public function contain(CurrencyCode $currencyCode): bool
    {
        return isset($this->array[$currencyCode->getValue()]);
    }

    public function remove(CurrencyCode $currencyCode): self
    {
        $self = clone $this;
        unset($self->array[$currencyCode->getValue()]);

        return $self;
    }

    public function getValueArray(): array
    {
        $list = [];

        foreach ($this->array as $currencyCode) {
            $list[] = $currencyCode->getValue();
        }

        return $list;
    }

    /**
     * @return CurrencyCode[]
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->array);
    }

    public function addItem(CurrencyCode $item): void
    {
        $this->array[$item->getValue()] = $item;
    }

    public function count(): int
    {
        return \count($this->array);
    }
}
