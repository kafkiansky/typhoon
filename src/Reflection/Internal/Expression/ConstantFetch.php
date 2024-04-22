<?php

declare(strict_types=1);

namespace Typhoon\Reflection\Internal\Expression;

use Typhoon\Reflection\Internal\ClassReflector;

/**
 * @internal
 * @psalm-internal Typhoon\Reflection
 */
final class ConstantFetch implements Expression
{
    /**
     * @param non-empty-string $name
     */
    public function __construct(
        private readonly string $name,
        private readonly ?string $global,
    ) {}

    public function evaluate(ClassReflector $classReflector): mixed
    {
        // TODO use constant reflection
        if ($this->global === null || \defined($this->name)) {
            return \constant($this->name);
        }

        return \constant($this->global);
    }
}