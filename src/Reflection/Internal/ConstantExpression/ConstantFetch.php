<?php

declare(strict_types=1);

namespace Typhoon\Reflection\Internal\ConstantExpression;

use Typhoon\Reflection\TyphoonReflector;

/**
 * @internal
 * @psalm-internal Typhoon\Reflection
 * @implements Expression<mixed>
 */
final class ConstantFetch implements Expression
{
    /**
     * @param non-empty-string $namespacedName
     * @param ?non-empty-string $globalName
     */
    public function __construct(
        private readonly string $namespacedName,
        private readonly ?string $globalName = null,
    ) {}

    /**
     * @return non-empty-string
     */
    public function name(?TyphoonReflector $_reflector = null): string
    {
        if ($this->globalName === null || \defined($this->namespacedName)) {
            return $this->namespacedName;
        }

        return $this->globalName;
    }

    public function recompile(CompilationContext $context): Expression
    {
        return $this;
    }

    public function evaluate(?TyphoonReflector $reflector = null): mixed
    {
        // todo via reflection
        return \constant($this->name($reflector));
    }
}
