<?php

declare(strict_types=1);

namespace Typhoon\Reflection\Internal\Expression;

use Typhoon\Reflection\Internal\ClassReflector;

/**
 * @internal
 * @psalm-internal Typhoon\Reflection
 */
final class UnaryOperation implements Expression
{
    /**
     * @param non-empty-string $operator
     */
    public function __construct(
        private readonly Expression $expression,
        private readonly string $operator,
    ) {}

    public function evaluate(ClassReflector $classReflector): mixed
    {
        return match ($this->operator) {
            '+' => +$this->expression->evaluate($classReflector),
            '-' => -$this->expression->evaluate($classReflector),
            '!' => !$this->expression->evaluate($classReflector),
            '~' => ~$this->expression->evaluate($classReflector),
        };
    }
}