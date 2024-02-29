<?php

declare(strict_types=1);

namespace Typhoon\Type;

/**
 * @internal
 * @psalm-internal Typhoon\Type
 * @implements Type<non-empty-string>
 */
final class ClassStringType implements Type
{
    public function __construct(
        private readonly Type $object,
    ) {}

    public function accept(TypeVisitor $visitor): mixed
    {
        return $visitor->classString($this, $this->object);
    }
}
