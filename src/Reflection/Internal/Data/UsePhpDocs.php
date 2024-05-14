<?php

declare(strict_types=1);

namespace Typhoon\Reflection\Internal\Data;

use Typhoon\TypedMap\OptionalKey;
use Typhoon\TypedMap\TypedMap;

/**
 * @internal
 * @psalm-internal Typhoon\Reflection\Internal
 * @implements OptionalKey<list<non-empty-string>>
 */
enum UsePhpDocs implements OptionalKey
{
    case Key;

    public function default(TypedMap $map): mixed
    {
        return [];
    }
}