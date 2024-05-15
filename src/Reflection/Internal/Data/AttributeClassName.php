<?php

declare(strict_types=1);

namespace Typhoon\Reflection\Internal\Data;

use Typhoon\TypedMap\Key;

/**
 * @internal
 * @psalm-internal Typhoon\Reflection\Internal
 * @implements Key<non-empty-string>
 */
enum AttributeClassName implements Key
{
    case Key;
}