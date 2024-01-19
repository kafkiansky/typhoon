<?php

declare(strict_types=1);

namespace Typhoon\Reflection;

use Typhoon\Reflection\Reflector\Reflection;
use Typhoon\Type\Type;
use Typhoon\Type\types;

/**
 * @api
 */
final class TemplateReflection extends Reflection
{
    /**
     * @internal
     * @psalm-internal Typhoon\Reflection
     * @param int<0, max> $position
     * @param non-empty-string $name
     */
    public function __construct(
        private readonly int $position,
        public readonly string $name,
        private readonly Type $constraint = types::mixed,
        private readonly Variance $variance = Variance::INVARIANT,
    ) {}

    /**
     * @return non-empty-string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int<0, max>
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    public function getConstraint(): Type
    {
        return $this->constraint;
    }

    public function getVariance(): Variance
    {
        return $this->variance;
    }

    public function __clone()
    {
        throw new ReflectionException();
    }

    protected function childReflections(): iterable
    {
        return [];
    }
}
