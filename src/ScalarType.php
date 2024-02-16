<?php

declare(strict_types=1);

namespace Typhoon\Type;

/**
 * @api
 * @implements Type<scalar>
 */
enum ScalarType implements Type
{
    /**
     * @internal
     * @psalm-internal Typhoon\Type
     */
    case type;

    public function accept(TypeVisitor $visitor): mixed
    {
        return $visitor->visitScalar($this);
    }
}
