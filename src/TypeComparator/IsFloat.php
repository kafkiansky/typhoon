<?php

declare(strict_types=1);

namespace Typhoon\TypeComparator;

use Typhoon\Type\Type;

/**
 * @internal
 * @psalm-internal Typhoon\TypeComparator
 */
final class IsFloat extends Comparator
{
    public function float(Type $self): mixed
    {
        return true;
    }

    public function floatValue(Type $self, float $value): mixed
    {
        return true;
    }
}
