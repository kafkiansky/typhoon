<?php

declare(strict_types=1);

namespace Typhoon\Type\Internal;

use Typhoon\Type\Type;
use Typhoon\Type\TypeVisitor;

/**
 * @internal
 * @psalm-internal Typhoon\Type
 * @implements Type<mixed>
 */
final class NotType implements Type
{
    public function __construct(
        private readonly Type $type,
    ) {}

    public function accept(TypeVisitor $visitor): mixed
    {
        return $visitor->not($this, $this->type);
    }
}
