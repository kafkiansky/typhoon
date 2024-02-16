<?php

declare(strict_types=1);

namespace Typhoon\Type;

/**
 * @api
 * @template-covariant TReturn
 * @implements Type<callable(): TReturn>
 */
final class CallableType implements Type
{
    /**
     * @var list<Parameter>
     */
    public readonly array $parameters;

    /**
     * @var ?Type<TReturn>
     */
    public readonly ?Type $returnType;

    /**
     * @internal
     * @psalm-internal Typhoon\Type
     * @param list<Parameter> $parameters
     * @param ?Type<TReturn> $returnType
     */
    public function __construct(
        array $parameters = [],
        ?Type $returnType = null,
    ) {
        $this->returnType = $returnType;
        $this->parameters = $parameters;
    }

    public function accept(TypeVisitor $visitor): mixed
    {
        return $visitor->visitCallable($this);
    }
}
