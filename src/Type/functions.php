<?php

declare(strict_types=1);

namespace Typhoon\Type;

use Typhoon\Type\Visitor\TypeStringifier;

/**
 * @api
 * @psalm-pure
 * @return non-empty-string
 */
function stringify(Type $type): string
{
    return $type->accept(TypeStringifier::Instance);
}
