<?php

declare(strict_types=1);

namespace Typhoon\TypeContext\Internal;

use Typhoon\Type\Type;
use Typhoon\Type\TypeVisitor;
use Typhoon\TypeContext\TraitTypesResolver;

/**
 * @internal
 * @psalm-internal Typhoon\TypeContext
 * @readonly
 * @implements Type<object>
 */
final class TraitStaticType implements Type
{
    /**
     * @param non-empty-string $trait
     * @param list<Type> $arguments
     */
    public function __construct(
        private readonly string $trait,
        private readonly array $arguments,
    ) {}

    /**
     * @template TReturn
     * @param TypeVisitor<TReturn> $visitor
     * @return TReturn
     */
    public function accept(TypeVisitor $visitor): mixed
    {
        if ($visitor instanceof TraitTypesResolver) {
            /** @var TReturn */
            return $visitor->traitStatic($this->arguments);
        }

        return $visitor->alias($this, 'static', 'trait-' . $this->trait, $this->arguments);
    }
}
