<?php

declare(strict_types=1);

namespace Typhoon\Type;

/**
 * @api
 * @template-covariant TType
 */
final class Parameter
{
    /**
     * @param Type<TType> $type
     */
    public function __construct(
        public readonly Type $type = types::mixed,
        public readonly bool $hasDefault = false,
        public readonly bool $variadic = false,
        public readonly bool $byReference = false,
    ) {}
}
