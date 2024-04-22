<?php

declare(strict_types=1);

namespace Typhoon\Reflection\Internal\Expression;

use Typhoon\Reflection\Internal\ClassReflector;

/**
 * @internal
 * @psalm-internal Typhoon\Reflection
 */
final class Instantiation implements Expression
{
    /**
     * @param array<Expression> $arguments
     */
    public function __construct(
        private readonly Expression $class,
        private readonly array $arguments,
    ) {}

    public function evaluate(ClassReflector $classReflector): mixed
    {
        /** @psalm-suppress MixedMethodCall */
        return new ($this->class->evaluate($classReflector))(...array_map(
            static fn(Expression $expression): mixed => $expression->evaluate($classReflector),
            $this->arguments,
        ));
    }
}