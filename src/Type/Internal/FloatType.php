<?php

declare(strict_types=1);

namespace Typhoon\Type\Internal;

use Typhoon\Type\Type;
use Typhoon\Type\TypeVisitor;

/**
 * @internal
 * @psalm-internal Typhoon\Type
 * @readonly
 * @template-covariant TValue of float
 * @implements Type<TValue>
 */
final class FloatType implements Type
{
    public function __construct(
        private readonly ?float $min,
        private readonly ?float $max,
    ) {}

    public function accept(TypeVisitor $visitor): mixed
    {
        return $visitor->float($this, $this->min, $this->max);
    }
}
