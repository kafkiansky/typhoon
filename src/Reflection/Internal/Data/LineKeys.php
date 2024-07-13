<?php

declare(strict_types=1);

namespace Typhoon\Reflection\Internal\Data;

use Typhoon\Reflection\Internal\TypedMap\OptionalKey;
use Typhoon\Reflection\Internal\TypedMap\TypedMap;

/**
 * @internal
 * @psalm-internal Typhoon\Reflection\Internal
 * @implements OptionalKey<?positive-int>
 */
enum LineKeys implements OptionalKey
{
    case Start;
    case End;
    case PhpDocStart;

    public function default(TypedMap $map): mixed
    {
        return null;
    }
}