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
     * @var Type<TType>
     */
    public readonly Type $type;

    public readonly bool $hasDefault;

    public readonly bool $variadic;

    /**
     * @internal
     * @psalm-internal Typhoon\Type
     * @param Type<TType> $type
     */
    public function __construct(
        Type $type = MixedType::type,
        bool $hasDefault = false,
        bool $variadic = false,
    ) {
        \assert(!($hasDefault && $variadic), 'Parameter can be either default or variadic.');

        $this->variadic = $variadic;
        $this->hasDefault = $hasDefault;
        $this->type = $type;
    }
}
