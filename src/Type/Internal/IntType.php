<?php

declare(strict_types=1);

namespace Typhoon\Type\Internal;

use Typhoon\Type\Type;
use Typhoon\Type\TypeVisitor;

/**
 * @internal
 * @psalm-internal Typhoon\Type
 * @readonly
 * @template-covariant TValue of int
 * @implements Type<TValue>
 */
final class IntType implements Type
{
    public function __construct(
        private readonly ?int $min,
        private readonly ?int $max,
    ) {}

    public function accept(TypeVisitor $visitor): mixed
    {
        return $visitor->int($this, $this->min, $this->max);
    }
}
