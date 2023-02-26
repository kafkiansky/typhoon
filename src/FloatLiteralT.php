<?php

declare(strict_types=1);

namespace PHP\ExtendedTypeSystem\Type;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-covariant TValue of float
 * @implements Type<TValue>
 */
final class FloatLiteralT implements Type
{
    /**
     * @param TValue $value
     */
    public function __construct(
        public readonly float $value,
    ) {
    }

    public function accept(TypeVisitor $visitor): mixed
    {
        return $visitor->visitFloatLiteral($this);
    }
}
