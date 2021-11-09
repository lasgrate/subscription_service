<?php

declare(strict_types=1);

namespace Phoenix\Payment\Lib;

abstract class AbstractEnum
{
    private string|int|float $value;

    /**
     * @var string[]|int[]|float[]
     */
    protected static array $list = [];

    /**
     * @var self[]
     */
    private static array $objects = [];

    private function __construct(string|int|float $value)
    {
        if (!self::inSet($value)) {
            throw new \InvalidArgumentException("Value `$value` is not in set");
        }

        $this->value = $value;
    }

    final public function getValue(): string|int|float
    {
        return $this->value;
    }

    /**
     * @return string[]|int[]|float[]
     */
    final public static function getList(): array
    {
        if (!isset(self::$list[static::class])) {
            $reflection = new \ReflectionClass(static::class);
            self::$list[static::class] = \array_values($reflection->getConstants());
        }

        return self::$list[static::class];
    }

    final public static function inSet(string|int|float $value): bool
    {
        return \in_array($value, self::getList(), true);
    }

    final public static function getObject(string|int|float $value): self
    {
        if (!isset(self::$objects[static::class][$value])) {
            self::$objects[static::class][$value] = new static($value);
        }

        return self::$objects[static::class][$value];
    }
}
